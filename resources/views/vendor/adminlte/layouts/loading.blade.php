<link rel="stylesheet" type="text/css" href="{{asset('css/loading.css')}}">
<div id="target" class="loading"></div>
<script type="text/javascript" src="{{asset('js/loading-overlay.min.js')}}"></script>
<script type="text/javascript">
	showLoading = function() {
		$("#target").css("display", "block");
		$("#target").loadingOverlay();
	};
	removeLoading = function() {
		$("#target").css("display", "none");
		$("#target").loadingOverlay('remove');
	}
</script>