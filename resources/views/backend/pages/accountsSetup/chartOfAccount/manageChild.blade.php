<ul>
    @foreach($childs as $child)
        <li>
            {{ $child->name }}
            @if(count($child->childs))
                 @include('backend.pages.accountsSetup.chartOfAccount.manageChild',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>
