let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  menuBtnChange();//calling the function(optional)

});

// following are the code to change sidebar button(optional)
function menuBtnChange() {
	if (sidebar.classList.contains("open")) {
		$('#chart_uso_dia').highcharts().setSize($(".box-1-2-1").width() - 86);
		$('#chart_uso_mes').highcharts().setSize($(".box-1-2-1").width() - 86);
		$('#uso_usuario_dia').highcharts().setSize($(".box-1-2-1").width() - 86);
		$('#uso_usuario_mes').highcharts().setSize($(".box-1-2-1").width() - 86);
	if(window.matchMedia('screen and (max-width: 600px)').matches) {
		$(".home-section").css("display", 'none');
	}
   closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
	} else {
		$('#chart_uso_dia').highcharts().setSize($(".box-1-2-1").width() + 86);
		$('#chart_uso_mes').highcharts().setSize($(".box-1-2-1").width() + 86);
		$('#uso_usuario_dia').highcharts().setSize($(".box-1-2-1").width() + 86);
		$('#uso_usuario_mes').highcharts().setSize($(".box-1-2-1").width() + 86);
	 if (window.matchMedia('screen and (max-width: 600px)').matches) {
		 $(".home-section").css("display", 'block');
	 }
   closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
 }

}