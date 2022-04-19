@extends('web.layouts.master')

@section('title')
Hotal Mohona


@section('frontend-content')

<section class="common-page-breadcumb">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="pagetitle-and-breadcumb wow slideInLeft" data-wow-duration="1s" data-wow-delay=".1s">
          <h3>Projects</h3>
          <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li>Projects</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ============================= -->
<section class="faund-pas-section">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="project-button-box">
          <h3>Residential</h3>
          <div class="btn-group btn-group-justified">
            <div class="btn-group">
              <button class="btn btn-default filter-button" data-filter="all">All</button>
            </div>
            <div class="btn-group">
              <button class="btn btn-default filter-button" data-filter="hdpe">Ongoing</button>
            </div>
            <div class="btn-group">
              <button class="btn btn-default filter-button" data-filter="sprinkle">Upcomming</button>
            </div>
            <div class="btn-group">
              <button class="btn btn-default filter-button" data-filter="spray">Complate</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="project-button-box">
          <h3>Commercial</h3>
          <div class="btn-group btn-group-justified">
            <div class="btn-group">
              <button class="btn btn-default filter-button" data-filter="all">All</button>
            </div>
            <div class="btn-group">
              <button class="btn btn-default filter-button" data-filter="hdpe">Ongoing</button>
            </div>
            <div class="btn-group">
              <button class="btn btn-default filter-button" data-filter="sprinkle">Upcomming</button>
            </div>
            <div class="btn-group">
              <button class="btn btn-default filter-button" data-filter="spray">Complate</button>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="row">

      <!-- ---------------- -->
      <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
        <div class="project-box-content">
          <div class="hoverable-box">
            <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
          </div>
          <img src="assets/images/project-1.jpg" class="img-responsive">
          <h3>BORAK MEHNUR</h3>
        </div>
      </div>

      <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter sprinkle">
       <div class="project-box-content">
        <div class="hoverable-box">
          <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
        </div>
        <img src="assets/images/project-2.jpg" class="img-responsive">
        <h3>BORAK MEHNUR</h3>
      </div>
    </div>

    <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
     <div class="project-box-content">
      <div class="hoverable-box">
        <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
      </div>
      <img src="assets/images/project-3.jpg" class="img-responsive">
      <h3>BORAK MEHNUR</h3>
    </div>
  </div>

  <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
   <div class="project-box-content">
    <div class="hoverable-box">
      <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
    </div>
    <img src="assets/images/project-4.jpg" class="img-responsive">
    <h3>BORAK MEHNUR</h3>
  </div>
</div>

<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter spray">
 <div class="project-box-content">
  <div class="hoverable-box">
    <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
  </div>
  <img src="assets/images/project-5.jpg" class="img-responsive">
  <h3>BORAK MEHNUR</h3>
</div>
</div>

<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
 <div class="project-box-content">
  <div class="hoverable-box">
    <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
  </div>
  <img src="assets/images/project-6.jpg" class="img-responsive">
  <h3>BORAK MEHNUR</h3>
</div>
</div>

<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter spray">
 <div class="project-box-content">
  <div class="hoverable-box">
    <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
  </div>
  <img src="assets/images/project-1.jpg" class="img-responsive">
  <h3>BORAK MEHNUR</h3>
</div>
</div>

<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
 <div class="project-box-content">
  <div class="hoverable-box">
    <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
  </div>
  <img src="assets/images/project-8.jpg" class="img-responsive">
  <h3>BORAK MEHNUR</h3>
</div>
</div>

<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter sprinkle">
 <div class="project-box-content">
  <div class="hoverable-box">
    <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
  </div>
  <img src="assets/images/project-9.jpg" class="img-responsive">
  <h3>BORAK MEHNUR</h3>

</div>
</div>
<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
 <div class="project-box-content">
  <div class="hoverable-box">
    <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
  </div>
  <img src="assets/images/project-1.jpg" class="img-responsive">
  <h3>BORAK MEHNUR</h3>
</div>
</div>

<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter spray">
 <div class="project-box-content">
  <div class="hoverable-box">
   <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
  </div>
  <img src="assets/images/project-2.jpg" class="img-responsive">
  <h3>BORAK MEHNUR</h3>
</div>
</div>

<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter sprinkle">
 <div class="project-box-content">
  <div class="hoverable-box">
    <a href="#" data-toggle="modal" data-target="#modal-fullscreen"><i class="fa fa-search"></i></a>
  </div>
  <img src="assets/images/project-3.jpg" class="img-responsive">
  <h3>BORAK MEHNUR</h3>
</div>
</div>

</div>
</section>
<!-- ========================================================= -->



<!-- Modal Fullscreen -->
<div class="modal fade modal-fullscreen" id="modal-fullscreen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header project-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-6">
            <div class="project-details-box">
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#ag">At A Glance</a></li>
                <li><a data-toggle="tab" href="#fp">Floor Plan</a></li>
                <li><a data-toggle="tab" href="#sf">Special Feature</a></li>
                <li><a data-toggle="tab" href="#lm">Location Map</a></li>
              </ul>

              <div class="tab-content">
                <div id="ag" class="tab-pane fade in active">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>Project Name <span class="table-colon">:</span></td>
                        <td>Real State Company..</td>
                      </tr>
                      <tr>
                        <td>Address<span class="table-colon">:</span></td>
                        <td> 51/B Kemal Ataturk Avenue, Banani, Dhaka</td>
                      </tr>
                      <tr>
                        <td>Project Orientation<span class="table-colon">:</span></td>
                        <td> South-East corner plot</td>
                      </tr>
                      <tr>
                        <td>Accessibility<span class="table-colon">:</span></td>
                        <td> Two way access roads</td>
                      </tr>
                      <tr>
                        <td>Building Type<span class="table-colon">:</span></td>
                        <td> Multistoried Commercial Building</td>
                      </tr>
                      <tr>
                        <td>Building Storey<span class="table-colon">:</span></td>
                        <td> 5 Basements + 20 Levels</td>
                      </tr>
                      <tr>
                        <td>Land Size<span class="table-colon">:</span></td>
                        <td> 14 Katha 13 Chatak (Approx.)</td>
                      </tr>
                      <tr>
                        <td>Space Size<span class="table-colon">:</span></td>
                        <td> 5674 sft (Approx.) office space per typical floors. Size Range: 2178-7816 sft (Approx.)</td>
                      </tr>
                      <tr>
                        <td>Car Parking<span class="table-colon">:</span></td>
                        <td> 114</td>
                      </tr>
                      <tr>
                        <td>Basements<span class="table-colon">:</span></td>
                        <td> 5 Layered Basements</td>
                      </tr>
                      <tr>
                        <td>Lifts<span class="table-colon">:</span></td>
                        <td> 3 High speed ThyssenKrupp lifts</td>
                      </tr>
                      <tr>
                        <td>Architect<span class="table-colon">:</span></td>
                        <td> Arch. Nusrat Zahan</td>
                      </tr>
                      <tr>
                        <td>Structural Engineer<span class="table-colon">:</span></td>
                        <td> A.K.M Saiful BAri & Abdulla Al Hossain</td>
                      </tr>
                      <tr>
                        <td>Approval<span class="table-colon">:</span></td>
                        <td> RAJUK Approved</td>
                      </tr>
                      <tr>
                        <td>Handover<span class="table-colon">:</span></td>
                        <td> in few months</td>
                      </tr>

                    </tbody>
                  </table>
                </div>
                <div id="fp" class="tab-pane fade">
                  <div class="row">
                    <div class="col-md-3">
                      <img src="assets/images/f.jpeg" class="img-responsive">
                    </div>
                    <div class="col-md-3">
                      <img src="assets/images/f2.jpeg" class="img-responsive">
                    </div>
                    <div class="col-md-3">
                      <img src="assets/images/f3.jpeg" class="img-responsive">
                    </div>
                    <div class="col-md-3">
                      <img src="assets/images/f4.jpeg" class="img-responsive">
                    </div>
                  </div>
                </div>
                <div id="sf" class="tab-pane fade">
                  <div class="special-feature">
                    <h4>THE LOCATION</h4>
                    <p>Place does matter! Borak Mehnur, South-East faced corner plot located at the most strategic place of Kemal Ataturk Avenue with multiple access facilities.</p>

                    <h4>STRUCTURAL STABILITY</h4>

                    <p>Being built with only the best construction material in close supervision of highly experienced engineers & professionals to ensure highest structural strength and stability against earthquake.



                      <h4>FIVE BASEMENTS<h4>

                        <p>This the only building having 5 basements in Kemal Ataturk Avenue can accommodate more car parks at its best.</p>



                        <h4>UNCOMPROMIZED SAFETY:</h4>

                        <p> kinds of state-of-the-art building and fire safety measures have been taken to make you 100% safe in this building.</p>



                        <h4>BEST-IN-CLASS FEATURES</h4>

                        <p>Best-in-class business feature & amenities have been chosen for this special building to give you the utmost feel of business luxury.</p>
                      </div>
                    </div>
                    <div id="lm" class="tab-pane fade">
                     <img src="assets/images/map.png" class="img-responsive">
                    </div>
                  </div>
                </div>
              </div>
              <!-- ============================= -->
              <div class="col-md-6">
                <div class="projectscaro-slide"> 
                  <div class="pro-slide-img">
                    <img src="assets/images/projects-s-1.jpg" class="img-responsive">
                  </div>
                  <div class="pro-slide-img">
                    <img src="assets/images/projects-s-2.jpg" class="img-responsive">
                  </div>
                  <div class="pro-slide-img">
                    <img src="assets/images/projects-s-3.jpg" class="img-responsive">
                  </div>
                  <div class="pro-slide-img">
                    <img src="assets/images/projects-s-4.jpg" class="img-responsive">
                  </div>
                  <div class="pro-slide-img">
                    <img src="assets/images/projects-s-5.jpg" class="img-responsive">
                  </div>
                </div>
              </div> 
            </div>

          </div>

        </div>
      </div>
    </div>



    
@endsection