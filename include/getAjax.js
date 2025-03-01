	function getAx (my_url, capa, alto) {
	   $.ajax({
					type: "GET",
					url: my_url,
					async:true,
					beforeSend: function(objeto){
						$("#"+capa).html("<table width='100%'><tr><td align='center' valign='middle' height='"+alto+"'><img src='images/indicator4.gif' width='31' height='31' border='0'></td></tr></table>");
					},	
					error: function(objeto, quepaso, otroobj){						
						$("#"+capa).html(quepaso);
					},
					success: function(html){
				   		$("#"+capa).html(html);
				  }
			});	   	   
	}
	function postAx (my_url,valores, capa, alto){
	   $.ajax({
					type: "POST",
					url: my_url,
					data: valores,
					async:true,
					beforeSend: function(objeto){
						$("#"+capa).html("<table width='100%'><tr><td align='center' valign='middle' height='"+alto+"'><img src='images/indicator4.gif' width='31' height='31' border='0'></td></tr></table>");
					},	
					error: function(objeto, quepaso, otroobj){						
						$("#"+capa).html(quepaso);
					},
					success: function(html){
				   		$("#"+capa).html(html);
				  }
			});	   	   
	}
