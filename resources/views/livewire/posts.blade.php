<div>
  
    
  
    @if($updateMode)
        @include('livewire.update')
    @elseif($createMode)
        @include('livewire.create')
    @else
        @include('livewire.list')
    @endif
  
    
</div>
