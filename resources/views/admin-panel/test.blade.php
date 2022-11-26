@extends('admin-panel.main')
@section('content')
<div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing" id="cancel-row">
                
                   <div class="col-lg-12 col-12  layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">                                
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Form groups</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <form style="padding: 5%;">
                                        <div class="form-group mb-4">
                                            <label for="formGroupExampleInput">Example label</label>
                                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="formGroupExampleInput2">Another label</label>
                                            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input">
                                        </div>
                                        <input type="submit" name="time" class="btn btn-primary">
                                    </form>
                                    </div>
                                </div>
                            </div>

                </div>

            </div>
        </div>
@endsection