<div>
    <div class="row">
        <div class="col-12">
            <table class="table table-responsive table-borderless">
                <thead>
                <tr>
                    <th>Setting/Property</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($configurations as $propertyId => $configuration)
                        <tr>
                            <td>{{$configuration['label']}}</td>
                            <td>
                                <select wire:model="values.{{$propertyId}}">
                                    <option>Select an option</option>
                                    @foreach($configuration['options'] as $value => $displayText)
                                        <option value="{{$value}}">{{$displayText}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <a href="#" wire:click="updateList('{{$propertyId}}')">Refresh List</a>

                                <div wire:ignore.self class="pleaseWaitSpinner {{$propertyId}} spinner-border text-primary float-left" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
