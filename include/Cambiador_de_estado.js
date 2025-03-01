	function Cambiador_de_estado(ID1,ID2) 
	{
	    this.ID1 = ID1;
	    this.ID2 = ID2;		
		this.Visible=true;
		this.Cambiar_Estado=Cambiar_Estado;
	} ;
	function Cambiar_Estado()
	{
		
		if (document.getElementById) 
		{ 
			objeto1 = document.getElementById( this.ID1 ) ;
			objeto2 = document.getElementById( this.ID2 ) ;
		} 
		else if (document.all) 
		{ 
			objeto1 = document.all[ this.ID1 ];
			objeto2 = document.all[ this.ID2 ];
		}	
		if ((objeto1!= undefined) && (objeto2!= undefined))
		{
			if (this.Visible)
			{
				//alert("estado_1");
				objeto1.style.display="none";	
				objeto2.style.display="block";
				this.Visible=false
			}
			else
			{
				//alert("estado_0");
				objeto1.style.display="block";	
				objeto2.style.display="none";
				this.Visible=true
			}		
		}		
	}
