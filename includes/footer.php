<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
			<i class="icon-double-angle-up icon-only bigger-110"></i>
		</a>
		<!--basic scripts-->
		<!--[if !IE]>-->
			<script src="js/jquery.2.0.3.min.js"></script>
		<!--<![endif]-->
		<!--[if IE]>
			<script src="js/jquery.1.10.2.min.js"></script>
		<![endif]-->
		<!--[if !IE]>
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo ASSETS.'js/jquery-2.0.3.min.js';?>'></script>");
		</script>
		<![endif]-->
		<!--[if IE]>
			<script type="text/javascript">
				window.jQuery || document.write("<script src='<?php echo ASSETS."js/jquery-1.10.2.min.js";?>'></script>");
			</script>
		<![endif]-->
		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo ASSETS.'js/jquery.mobile.custom.min.js'; ?>'>"+"<"+"/script>");
		</script>
		<script src="<?php echo ASSETS.'js/bootstrap.min.js';?>"></script>