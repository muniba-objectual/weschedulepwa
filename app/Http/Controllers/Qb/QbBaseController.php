<?php

namespace App\Http\Controllers\Qb;

use App\Http\Controllers\Controller;
use App\Models\QuickbooksToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Exception\SdkException;
use QuickBooksOnline\API\Exception\ServiceException;


/**
 * @property DataService $dataService
*/
class QbBaseController extends Controller
{
    use QbApiCore;

    public function getCompanyInfo(): JsonResponse|RedirectResponse
    {
        $qbConnection = $this->initQbConnection();
        if ($qbConnection instanceof RedirectResponse) {
            // Redirect to the intended URL
            return $qbConnection;
        }

        try {
            // Retrieve the company information using the DataService object
            $companyInfo = $this->dataService->getCompanyInfo();
            $this->handleError();

            // Process the company information
            $companyData = [
                'id' => $companyInfo->Id,
                'name' => $companyInfo->CompanyName,
                // Add more fields as needed
            ];

            // Return the company data
            return response()->json(['company' => $companyData]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the API request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function authorizeQbConnection(): \Illuminate\Http\RedirectResponse
    {
        //if this route was directly called, then there is no previous route where you tried to execute, therefore redirect the QB dashboard after QB authorization.
        if(!Session::has('url.intended')){
            Session::put('url.intended', route('qb.dashboard'));
        }

        // Redirect the user to the authorization URL
        return redirect()->away(
            DataService::Configure($this->getConnectionConfig())
                ->getOAuth2LoginHelper()
                ->getAuthorizationCodeURL()
        );
    }


    /**
     * @throws ServiceException
     * @throws SdkException|\Throwable
     */
    public function callback(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $accessToken = DataService::Configure($this->getConnectionConfig())
            ->getOAuth2LoginHelper()
            ->exchangeAuthorizationCodeForToken(
                $request->input('code'),
                $request->input('realmId'),
            );

        // Store the access in the database
        $token = new QuickbooksToken();
        $token->serialized_access_token = $accessToken;
        $token->other_details = json_encode($request->all()); //save the payload for later troubleshooting.
        $token->save();

        $intendedUrl = Session::pull('url.intended'); // Get the intended URL if it exists

        // Redirect to the intended URL or a default success page
        return redirect($intendedUrl ?? '/?qb=ok');
    }


    public function eula() {
        return view('qb.eula');
    }

    public function privacy() {
        return view('qb.privacy');
    }
}
