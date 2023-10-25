<x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
    <x-slot name="title">SRA Report</x-slot>

    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="shadow border border-radius-lg">
              <div class="d-flex justify-content-end bg-sra py-2 px-2 border-top-right-radius border-top-left-radius">
                <button type="button"
                  class="d-flex justify-content-center align-items-center btn bg-gradient-dark mb-0"><img
                    src="{{ asset('img/print.svg') }}" />
                  &nbsp;&nbsp;Print
                </button>
                <button type="button"
                  class="d-flex justify-content-center align-items-center btn bg-gradient-dark mb-0 ml-2"><img
                    src="{{ asset('img/save.svg') }}" />
                  &nbsp;&nbsp;Save
                </button>
              </div>
              <div class="d-flex px-3">
                <p class="text-sm w-50 text-dark">8/10/23, 4:49 PM</p>
                <p class="text-sm w-50 text-dark">We-Schedule</p>
              </div>
              <div class="px-3">
                <img src="{{ asset('img/ban-pdf.png') }}" class="w-100" />
                <h6 class="mt-3 text-center text-dark">Special Rate Agreement Signature Sheet for Hours Worked</h6>
                <h6 class="text-underline mt-2 text-center text-dark">Must Be Completed and Attached to All Invoices</h6>
              </div>
              <div class="px-3 pdfTable py-3 table-responsive ">
                <table class="w-100">
                  <tr>
                    <td class="text-sm text-dark"><b>Month:</b></td>
                    <td class="text-sm text-dark">Feb 2023</td>
                    <td class="text-sm text-dark"><b>Child/Youth’s<br />
                        Name:<br />
                        Preferred pronoun</b></td>
                    <td class="text-sm text-dark" colspan="2"><b>Adam Smith
                      </b></td>
                  </tr>
                  <tr>
                    <td class="text-sm text-dark">Date of<br />
                      Approved SRA :</td>
                    <td class="text-sm text-dark" colspan="4"><b>Sep 08, 2023</b></td>
                  </tr>
                  <tr>
                    <td class="text-sm text-dark"><b>Date</b></td>
                    <td class="text-sm text-dark"><b>Activities spent in 1-1 time (please
                        detail by hour, where the 1-1 time
                        was provided & relatedness of
                        activity to initial goal of SRA )</b></td>
                    <td class="text-sm text-dark"><b>Total #
                        Hours
                        Worked</b>
                    </td>
                    <td class="text-sm text-dark"><b>Name 1-1<br />
                        worker<br />
                        (PLEASE<br />
                        PRINT)</b></td>
                    <td class="text-sm text-dark"><b>Staff Signature</b>
                    </td>
                  </tr>
                  <tr>
                    <td>Feb 06
                      2023</td>
                    <td>test</td>
                    <td>7.5</td>
                    <td>Bobby Handles </td>
                    <td><img src="{{ asset('img/sign1.png') }}" width="200px" /></td>
                  </tr>
                  <tr>
                    <td class="text-sm text-dark" colspan="2"><b>Total Hours Worked</b></td>
                    <td class="text-sm text-dark"><b>7.5</b></td>
                    <td></td>
                    <td></td>
                  </tr>
                </table>
                <p class="text-sm text-dark mt-3"><b>Signature of person with authority to bind the Resource</b></p>
                <img src="{{ asset('img/sign2.png') }}" width="200px" />
                <p class="text-sm text-dark mt-3"><b>Joint OACAS/ANCFSAO Residential Services Critical Issues
                    Implementation</b></p>
              </div>
            </div>
          </div>
        </div>
    </div>
</x-wire-elements-pro::bootstrap.modal>