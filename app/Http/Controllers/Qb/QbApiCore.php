<?php

namespace App\Http\Controllers\Qb;

use App\Models\QuickbooksToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Exception\SdkException;
use QuickBooksOnline\API\Exception\ServiceException;

trait QbApiCore
{
    protected DataService $dataService;

    protected function syncQbCollection(string $label, string $baseQuery, \Closure $function, bool $printLogs = false, Request $request = null, \Illuminate\Console\Command $command = null)
    {
        //TODO::ashain, create a separate log file for syncs.

        $qbConnection = $this->initQbConnection();
        if ($qbConnection instanceof RedirectResponse) {
            // Redirect to the intended URL
            return $qbConnection;
        }


        // Log the synchronized vendor
        Log::info("`{$label}` Synchronizing Started.");
        if($printLogs){
            $this->print("`{$label}` Synchronizing Started.", $request, $command);
        }

        try {
            $offset = 0; // Initialize the offset
            $limit = 100; // Set the limit to 100 (default limit)
            $totalSynced = 0; // Initialize a variable to keep track of total synced records

            do {
                // Query the vendors using the Vendor entity with offset and limit
                $qbCollection = $this->dataService->Query($baseQuery." STARTPOSITION {$offset} MAXRESULTS {$limit}");

                $this->handleError();

                // Process the vendors
                foreach ($qbCollection ?? [] as $qbModel) {

                    $localModel = $function($qbModel);

                    if($localModel === null){
                        continue;
                    }

                    if($printLogs){
                        $dataLog = json_encode($localModel->toArray(), true);
                        $this->print("{$dataLog} synced!", $request, $command);
                    }

                    $totalSynced++; // Increment the total number of synced records
                }

                // Increment the offset to fetch the next batch of records
                $offset += $limit;

                // Repeat the loop until all vendors are fetched
            } while (!empty($qbCollection));


            // Log the synchronization completed with the total number of records synced
            Log::info("`{$label}` Synchronization Completed. Total Records Synced: " . $totalSynced);
            if($printLogs){
                $this->print("`{$label}` Synchronization Completed. Total Records Synced: " . $totalSynced, $request, $command);
            }

        } catch (\Exception $e) {
            // Log the error
            Log::error("Error Synchronizing `{$label}`: " . $e->getMessage());

            if($printLogs){
                $this->print("Error Synchronizing `{$label}`: " . $e->getMessage(), $request, $command);
            }
        }
    }


    protected function handleError(bool $showErrors = true, &$error = null): void
    {
        if($showErrors){
            $error = $this->dataService->getLastError();
            if ($error) {
                echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
                echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                echo "The Response message is: " . $error->getResponseBody() . "\n";
            }
        }
    }


    /**
     * @throws \Throwable
     * @throws SdkException
     * @throws ServiceException
     */
    protected function initQbConnection()
    {
        $this->validateAppConfigForQb();

        /**
         * Retrieve the latest token from the database
         * @var QuickbooksToken $latestToken
         */
        $latestToken = QuickbooksToken::latest()->first();

        if (!$latestToken) {
            Session::put('url.intended', request()->fullUrl()); // Save the current URL as intended
            return redirect()->route('qb.authorize');
        }

        // Retrieve the access token instance
        $oauth2Token = $latestToken->serialized_access_token;

        if( $latestToken->goingToExpire() ){

            $dataService = DataService::Configure($this->getConnectionConfig([
                'refreshTokenKey'   => $oauth2Token->getRefreshToken(),
                'QBORealmID'        => $oauth2Token->getRealmID(),
            ]));

            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();
            $dataService->updateOAuth2Token($refreshedAccessTokenObj);

            //store the updated access token
            $latestToken->serialized_access_token = $refreshedAccessTokenObj;
            $latestToken->save();
        }else{
            $dataService = DataService::Configure($this->getConnectionConfig());
            $dataService->updateOAuth2Token($oauth2Token);
        }

        //setup instance variables
        $this->dataService = $dataService;
    }


    /**
     * @throws \Throwable
     */
    protected function getConnectionConfig(array $additionalConf = [], string $mode = 'accounting'): array{
        switch($mode){
            case 'accounting' : $scope = 'com.intuit.quickbooks.accounting';break;
            case 'payments' : $scope = 'com.intuit.quickbooks.payment';break;
            default: throw new \Exception('Invalid QB scope mode.');
        }

        $this->validateAppConfigForQb();

        return [
                'auth_mode'     => 'oauth2',
                'ClientID'      => config('app.quickbooks_client_id'),
                'ClientSecret'  => config('app.quickbooks_client_secret'),
                'RedirectURI'   => config('app.quickbooks_redirect_uri', url('/qb/callback')),
                'scope'         => $scope,
                'baseUrl'       => config('app.quickbooks_base_url')
            ] + $additionalConf;
    }

    /**
     * @throws \Throwable
     */
    protected function validateAppConfigForQb(): void
    {
        throw_if(   empty(config('app.quickbooks_client_id')),     "`QUICKBOOKS_CLIENT_ID` not set in ENV");
        throw_if(   empty(config('app.quickbooks_client_secret')), "`QUICKBOOKS_CLIENT_SECRET` not set in ENV");
        throw_if(   empty(config('app.quickbooks_base_url')),      "`QUICKBOOKS_BASE_URL` not set in ENV, should be: `Development` or `Production`");
    }

    protected function print(string $content, Request $request = null, \Illuminate\Console\Command $command = null): void
    {
        $isInConsoleMode = !is_null($command);

        if($isInConsoleMode){
            $command->info($content);
        }else{
            echo '<br/>'.$content.'<br/>';
        }
    }

}
