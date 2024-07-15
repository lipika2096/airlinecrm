<div class="setup-welcome" id="setup-welcome">

    <!--image-->
    <div class="x-image">
        <img src="{{asset('/public/images/wizard.png')}}">
    </div>

    <!--title-->
    <div class="x-title">
        <h2 class="text-info">Installation</h2>
    </div>

    <div class="x-subtitle">
        This wizard will guide you through the installation process. For help, please refer to our <a
            href="https://growcrm.io/documentation/">documentation</a>.
        </br>
    </div>

    <!--item-->
    <div class="form-group row">
        <label class="col-sm-12 control-label col-form-label required">Product Purchase Code</label>
        <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" name="purchase_code"
                value="">
        </div>
    </div>

    <div class="alert alert-info">Your product purchase code is available inside your Envato (Codecanyon) dashboard. 
        <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">More Details</a></div>

       
    <form action="{{ url('setup/requirements') }}" method="post">
    <div class="x-button m-t-30">
        <button type="submit" class="btn waves-effect waves-light btn-block btn-info ">Start Installation</button>
    </div>
</form>

</div>