@if ($this->sortField !== $field)
    <i class="fas fa-sort text-gray-600"></i>
@elseif ($this->sortAsc)
    <i class="fas fa-sort-up"></i>
@else
    <i class="fas fa-sort-down"></i>
@endif

