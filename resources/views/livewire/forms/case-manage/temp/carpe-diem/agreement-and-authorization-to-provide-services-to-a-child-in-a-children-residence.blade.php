<div>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 14px;
                }

                .header {
                    text-align: center;
                    font-size: 18px;
                    font-weight: bold;
                    margin-bottom: 20px;
                }

                .section-heading {
                    font-size: 16px;
                    font-weight: bold;
                    margin-top: 20px;
                    margin-bottom: 10px;
                }

                .label {
                    font-weight: bold;
                }

                .input-field {
                    border: none;
                    border-bottom: 1px dotted #000;
                    outline: none;
                    padding: 2px;
                }

                .signature {
                    margin-top: 50px;
                    text-align: center;
                }

                .signature td {
                    text-align: center;
                }

                .logo{
                    text-align: center;
                }

                .spacer{
                    width: 50%;
                }

                textarea, input[type="text"] {
                    background: #f4eef1;
                }
            </style>

            @php
                $config = [
                    "singleDatePicker" => true,
                    "showDropdowns" => true,
                    "startDate" => "js:moment()",
                    "minYear" => 2000,
                    "maxYear" => "js:parseInt(moment().format('YYYY'),10)",
                    "timePicker" => true,
                    "timePicker24Hour" => false,
                    "timePickerSeconds" => false,
                    "cancelButtonClasses" => "btn-danger",
                    "locale" => ["format" => "YYYY-MM-DD HH:mm"],
                ];
            @endphp

            <form wire:submit.prevent="submit">
                <div class="logo">
                    <img width="166" height="116" src="data:image/jpg;base64,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"/>
                </div>

                <div class="header">
                    AGREEMENT AND AUTHORIZATION<br>
                    TO PROVIDE SERVICES TO A CHILD IN A CHILDREN’S RESIDENCE<br>
                    Revised January 2021
                </div>

                <p>
                    The purpose of this agreement is to ensure that the operation of a children’s residence is properly authorized to provide for the care of a child, as required by The Child, Youth and Family Services Act. This agreement must be entered into on the day that the child is placed in the residence, or as soon as possible in the circumstances.
                </p>

                <p>
                    This agreement hereby authorizes Blair Lewis of CARPE DIEM RESIDENTIAL TREATMENT HOMES FOR CHILDREN INC. to:
                </p>
                <ol>
                    <li>
                        Provide residential care for <span class="label">Name of Child</span> <input type="text" class="input-field" wire:model="formData.childName">
                        at (location) <span class="label">(Name of Foster Parents)</span> <input type="text" class="input-field" wire:model="formData.location">
                        from the date of admission on <span class="label"></span> <x-adminlte-date-range name="formData_date_of_placement_call" wire:model="formData.admission_on" igroup-size="sm" class="input-field" :config="$config"/>
                    </li>
                    <li>Obtain emergency medical or dental treatment for the above-named child</li>
                    <li>Where applicable, inspect and obtain from persons or agencies named in the agreement, records, reports, and information concerning the above-named child.</li>
                </ol>

                <p>
                    It is further agreed that financial and other responsibilities will be undertaken in accordance with the Resource Services Agreement, the content of which has been explained and is herein acknowledged.
                </p>

                <p>
                    A review of this agreement, to provide services to the child, shall occur at the request of the child, a parent of the child, or the Society, or other person placing the child, or the operator.
                </p>

                <p>
                    HEALTH CARD NUMBER: <input type="text" class="input-field" wire:model="formData.healthCardNumber"> Version Code: <input type="text" class="input-field" wire:model="formData.versionCode">
                </p>

                <p>Signed and Dated in agreement this <input placeholder="(day)" type="text" class="input-field" wire:model="formData.day"> of <input placeholder="(Month / Year)" type="text" class="input-field" wire:model="formData.monthYear">.</p>

                <div class="signature">
                    <table style="font-size: 0.75em; width: 90%;">
                        <tr>
                            <td><input type="text" class="input-field" wire:model="formData.operatorDirector_signature"></td>
                            <td class="spacer">&nbsp;&nbsp;&nbsp;</td>
                            <td><input type="text" class="input-field" wire:model="formData.referringAgency_signature"></td>
                        </tr>
                        <tr>
                            <td><span class="signature">(Operator – Carpe Diem Director)</span></td>
                            <td class="spacer">&nbsp;&nbsp;&nbsp;</td>
                            <td><span class="signature">(Referring Agency)</span></td>
                        </tr>

                        <tr>
                            <td colspan="3"><br/><br/><br/></td>
                        </tr>

                        <tr>
                            <td><input type="text" placeholder="" class="input-field" wire:model="formData.guardian_signature"></td>
                            <td class="spacer">&nbsp;&nbsp;&nbsp;</td>
                            <td><input type="text" placeholder="" class="input-field" wire:model="formData.child_signature"></td>
                        </tr>
                        <tr>
                            <td><span class="signature">(Parent/Referring Agency Guardian where relevant)</span></td>
                            <td class="spacer">&nbsp;&nbsp;&nbsp;</td>
                            <td><span class="signature">(Child over 16 years old)</span></td>
                        </tr>
                    </table>
                </div>

                <br/><br/>

                <p class="footer">
                    <i>9355 Dixie Road, Brampton, ON L6S 1J7 Tel: 905.799.2947 Fax: 905.790.8262 www.carpediem.ca</i>
                </p>

                <button type="submit">Submit</button>
                <button type="button">Email</button>
            </form>

</div>
