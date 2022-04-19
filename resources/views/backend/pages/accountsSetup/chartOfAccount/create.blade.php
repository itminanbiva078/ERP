@extends('backend.layouts.master')

@section('title')
Accounts - {{$title}}
@endsection
@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Account </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    @if(helper::roleAccess('accountSetup.chartOfAccount.index'))
                    <li class="breadcrumb-item"><a href="{{ route('accountSetup.chartOfAccount.index') }}">Account
                            List</a>
                    </li>
                    @endif
                    <li class="breadcrumb-item active"><span>Add New Account</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Add New Account</h3>
                <div class="card-tools">
                    @if(helper::roleAccess('accountSetup.chartOfAccount.index'))
                    <a class="btn btn-default" href="{{ route('accountSetup.chartOfAccount.index') }}"><i
                            class="fa fa-list"></i>
                        Account List</a>
                    @endif
                    <span id="buttons"></span>

                    <a class="btn btn-tool btn-default" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </a>
                    <a class="btn btn-tool btn-default" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="needs-validation" method="POST" action="{{ route('accountSetup.chartOfAccount.store') }}"
                    novalidate>
                    @csrf
                    @if(!empty($formInput) && is_array($formInput))
                    <div class="form-row">
                        @foreach ($formInput as $key => $eachInput)
                        @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                        @endforeach
                    </div>



                    <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>
                    @else
                    <div class="alert alert-default">
                        <strong>Warning!</strong> Sorry you have no form access !!.
                    </div>
                    @endif
                </form>

                


            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="col-md-12">
                    <div class="file-browser">
                        <ul>
                            <li class="folder folder-open">
                                <span> <i class="far fa-folder-open"></i> Dashboard </span>
                                <ul>
                                    <li class="file">Accounts Module</li>
                                    <li class="file">Help Module</li>
                                </ul>
                            </li>
                            <li class="folder">
                                <span> <i class="far fa-folder-open"></i> Transfers </span>
                                <ul>
                                    <li class="folder folder-open">
                                        <span> Quick </span>
                                        <ul>
                                            <li class="file">Disclosures</li>
                                            <li class="file">Modals</li>
                                        </ul>
                                    </li>
                                    <li class="file">Classic</li>
                                    <li class="folder">
                                        <span> Scheduled </span>
                                        <ul>
                                            <li class="folder">
                                                <span> Calendar </span>
                                                <ul>
                                                    <li class="file">Days</li>
                                                    <li class="file">Months</li>
                                                </ul>
                                            </li>
                                            <li class="file">Modals</li>
                                        </ul>
                                    </li>
                                    <li class="file">History</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
@endsection

@section('scripts')

    <script>
$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'background-image: url(https://img.icons8.com/color/48/000000/plus.png)';
      var closedClass = 'fa fa-minus';
      
      if (typeof o!= 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        /* initialize each of the top levels */
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this);
            branch.prepend("");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        /* fire event from the dynamically added icon */
        tree.find('.branch .indicator').each(function(){
            $(this).on('click', function () {
                $(this).closest('li').click();
            });
        });
        /* fire event to open branch if the li contains an anchor instead of text */
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        /* fire event to open branch if the li contains a button instead of text */
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});
/* Initialization of treeviews */
// $('#tree1').treed();

$(function() {
    $('.folder').on('click', function(e) {
        $(this).toggleClass('folder-open');
        e.stopPropagation();
    });
    
    $('.file').on('click', function(e) {
       e.stopPropagation(); 
    });
})


    </script>

@endsection