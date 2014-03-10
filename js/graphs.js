function refreshImages() {
    if(dev == null || dev == "")
	return;

    t = new Date();
    $("#graph-day").attr("src", "getGraph.php?d&t=" + t + "&dev=" + dev);
    $("#graph-week").attr("src", "getGraph.php?w&t=" + t + "&dev=" + dev);
    $("#graph-month").attr("src", "getGraph.php?m&t=" + t + "&dev=" + dev);
}

$(document).ready(function () {
    setInterval("refreshImages();", 300000);
    
    $("#dev-chooser").change(function() {
	newDev = $(this).val();
	if(newDev != "" && newDev != dev)
	    window.location.assign("index.php?dev=" + newDev);
    });
});
