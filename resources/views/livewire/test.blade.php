<div wire:ignore>
<form method="POST" wire:submit.prevent="submit">

    <input id="name" wire:model.debounce.500ms="name">

    <x-media-library-attachment name="myUpload" />

    <button type="submit">Submit</button>
</form>
</div>>

