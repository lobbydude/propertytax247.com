<?php
setcookie("TestCookie", 'Some Value', time()+3600, "/", "https://propertyreport247.com/orders", 1);
?>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url('assets/global/img/favicon.ico')?>" />
<!-- BEGIN PACE PLUGIN FILES -->
<script src="<?php echo site_url('assets/global/plugins/pace/pace.min.js') ?>" type="text/javascript"></script>
<link href="<?php echo site_url('assets/global/plugins/pace/themes/pace-theme-flash.css') ?>" rel="stylesheet" type="text/css"/>
<!-- END PACE PLUGIN FILES -->
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo site_url('assets/global/plugins/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
<link href="<?php echo site_url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') ?>" rel="stylesheet" type="text/css">
<link href="<?php echo site_url('assets/global/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
<link href="<?php echo site_url('assets/global/plugins/uniform/css/uniform.default.css') ?>" rel="stylesheet" type="text/css">
<link href="<?php echo site_url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') ?>" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') ?>"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo site_url('assets/global/css/components-rounded.css') ?>" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url('assets/global/css/plugins.css') ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo site_url('assets/admin/layout4/css/layout.css') ?>" rel="stylesheet" type="text/css"/>
<link id="style_color" href="<?php echo site_url('assets/admin/layout4/css/themes/light.css') ?>" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/plugins/select2/select2.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/plugins/jquery-multi-select/css/multi-select.css') ?>"/>

<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/css/custom.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css') ?>"/>
<link rel="shortcut icon" href="favicon.ico"/>

<script src="<?php echo site_url('assets/global/plugins/jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/global/plugins/jquery-migrate.min.js') ?>" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo site_url('assets/global/plugins/jquery-ui/jquery-ui.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/global/plugins/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/global/plugins/jquery.blockui.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/global/plugins/jquery.cokie.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/global/plugins/uniform/jquery.uniform.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') ?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo site_url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/global/plugins/jquery-validation/js/additional-methods.min.js') ?>"></script>

<script type="text/javascript" src="<?php echo site_url('assets/global/plugins/bootstrap-select/bootstrap-select.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/global/plugins/select2/select2.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') ?>"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<script src="<?php echo site_url('assets/global/scripts/metronic.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/admin/layout4/scripts/layout.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/admin/layout4/scripts/demo.js') ?>" type="text/javascript"></script>
<!-- FORM VALIDATION START HERE -->
<script src="<?php echo site_url('assets/admin/pages/scripts/plan-validation.js') ?>"></script>
<script src="<?php echo site_url('assets/admin/pages/scripts/planwise-validation.js') ?>"></script>
<script src="<?php echo site_url('assets/admin/pages/scripts/priority-validation.js') ?>"></script>
<script src="<?php echo site_url('assets/admin/pages/scripts/price-validation.js') ?>"></script>
<!-- FORM VALIDATION END HERE -->
<script type="text/javascript" src="<?php echo site_url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') ?>"></script>
<script src="<?php echo site_url('assets/admin/pages/scripts/table-managed.js') ?>"></script>
<script src="<?php echo site_url('assets/admin/pages/scripts/components-dropdowns.js') ?>"></script>
<script src="<?php echo site_url('assets/admin/pages/scripts/form-wizard.js') ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')?>" type="text/javascript"></script>
<script>
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Demo.init(); // init demo features
        TableManaged.init();
        PlanFormValidation.init();
        PlanwiseFormValidation.init();
        PriorityFormValidation.init();
        PriceFormValidation.init();
        ComponentsDropdowns.init();
        FormWizard.init();
    });
</script>

<script>
$(document).ready(function(){
    $(document).ajaxStart(function(){
        $(".loading").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $(".loading").css("display", "none");
    });
});
</script>
<!-- Export Table Data -->
<script src="<?php echo site_url('assets/global/export/jquery.btechco.excelexport.js')?>"></script>
<script src="<?php echo site_url('assets/global/export/jquery.base64.js')?>"></script>

<script>
    $(document).ready(function () {
        $("#btnExport").click(function () {
            $("#Export_Excel").btechco_excelexport({
                containerid: "Export_Excel",
                datatype: $datatype.Table,
                title:"History"
            });
        });
    });
</script>
<!--Start Google Analytics Code -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-79457004-1', 'auto');
  ga('send', 'pageview');
</script>
<!-- End Google Analytics Code-->

<!-- Disable mouse right click Start here-->
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
$(document).ready(function () {
	//Disable cut copy paste
	$('body').bind('cut copy paste', function (e) {
		e.preventDefault();
	});	
	//Disable mouse right click
	  $(document).bind("contextmenu", function (e) {
            e.preventDefault();
            alert("Right Click is Disabled");
        });
});
</script>

<!-- Ctrl+P and Ctrl+U disable Start Code-->
<script type="text/javascript">
document.onkeydown = function (cc) {
if(cc.which == 85){
return false;
}
if(cc.which == 80){
return false;
}
}
</script>
<!-- Ctrl+P and Ctrl+U disable End Code-->
<!-- F12 & Firebug and INSPECT ELEMENT disable Start here-->
<script> 
	$(document).keydown(function(e){
    if(e.which === 123){
       return false;
    }
});	
</script>
<!-- F12 & Firebug and INSPECT ELEMENT disable End here-->


