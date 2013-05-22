function refreshImages() {
    t = new Date();
    $("#graph-day").attr("src", "getGraph.php?d&t=" + t);
    $("#graph-week").attr("src", "getGraph.php?w&t=" + t);
    $("#graph-month").attr("src", "getGraph.php?m&t=" + t);
}

$(document).ready(function () {
    setInterval("refreshImages();", 300000);
});