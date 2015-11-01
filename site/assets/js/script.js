function saveTargetBalance(){
	var updBalance = {};
	jQuery("#updateTargetForm :input").each(function(idx,ele){
		updBalance[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_ddcbalanceit&controller=add&format=raw&tmpl=component',
		type:'POST',
		data:updBalance,
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success == true ){
				jQuery("#targetModal").modal('hide');
				
			}else{

			}
		}
	});
	setTimeout(function() 
	{
		location.reload();
	}, 0500);
	
}

function updateTarget(target){

	var tableval = "ddctargets";
	jQuery.ajax({
		url:'index.php?option=com_ddcbalanceit&controller=get&format=raw&tmpl=component&table='+tableval+'&ddctarget_id='+target,
		type:'get',
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				jQuery("#jform_target_date").val(data.html.target_date);
				jQuery("#jform_target_balance").val(Math.abs(data.html.target_balance));
				jQuery("#jform_ddcbi_target_id").val(data.html.ddcbi_balance_id);
				jQuery("#jform_account_id").val(data.html.ddcbi_account_id);
				jQuery("#jform_accounttype_id").val(data.html.ddcbi_accounttype_id);
				if(data.html.target_balance < 0){jQuery("#jform_plus_minus").val(0);}
				if((data.html.target_balance < 0)){jQuery("#jform_debit_credit").val("cr");}
				jQuery("#jform_account_nature").val(data.html.account_nature);
				jQuery(".deletebtn").show();
			}else{

			}
		}
	});
	
}

function deleteTarget() {
    if (confirm("Are you sure you want to delete this entry?") == true) {
    	var targetInfo = {};
    	jQuery("#updateTargetForm :input").each(function(idx,ele){
    		targetInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
    	});

    	jQuery.ajax({
    		url:'index.php?option=com_ddcbalanceit&controller=delete&format=raw&tmpl=component',
    		type:'POST',
    		data:targetInfo,
    		dataType:'JSON',
    		success:function(data)
    		{
    			if ( data.success == true ){
    				jQuery("#targetModal").modal('hide');
    			}else{

    			}
    		}
    	});
    	setTimeout(
    	    	function() 
    	      {
    	      	location.reload();
    	      }, 0500);
    } else {
        //show box as normal
    }
    
}

function saveBalance(){
	var updBalance = {};
	jQuery("#updateBalanceForm :input").each(function(idx,ele){
		updBalance[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_ddcbalanceit&controller=add&format=raw&tmpl=component',
		type:'POST',
		data:updBalance,
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success == true ){
				jQuery("#balanceModal").modal('hide');
				
			}else{

			}
		}
	});
	setTimeout(function() 
	{
		location.reload();
	}, 0500);
	
}

function updateBalance(balance){

	var tableval = "ddcbalances";
	jQuery.ajax({
		url:'index.php?option=com_ddcbalanceit&controller=get&format=raw&tmpl=component&table='+tableval+'&ddcbalance_id='+balance,
		type:'get',
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				jQuery("#jform_record_date").val(data.html.record_date);
				jQuery("#jform_balance").val(Math.abs(data.html.balance));
				jQuery("#jform_ddcbi_balance_id").val(data.html.ddcbi_balance_id);
				jQuery("#jform_ddcbi_account_id").val(data.html.an);
				if(data.html.balance < 0){jQuery("#jform_plus_minus").val(0);}
				if((data.html.balance < 0)){jQuery("#jform_debit_credit").val("cr");}
				jQuery("#jform_account_nature").val(data.html.account_nature);
				jQuery(".deletebtn").show();
			}else{

			}
		}
	});
	
}

function deleteBalance() {
    if (confirm("Are you sure you want to delete this entry?") == true) {
    	var balanceInfo = {};
    	jQuery("#updateBalanceForm :input").each(function(idx,ele){
    		balanceInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
    	});

    	jQuery.ajax({
    		url:'index.php?option=com_ddcbalanceit&controller=delete&format=raw&tmpl=component',
    		type:'POST',
    		data:balanceInfo,
    		dataType:'JSON',
    		success:function(data)
    		{
    			if ( data.success == true ){
    				jQuery("#balanceModal").modal('hide');
    			}else{

    			}
    		}
    	});
    	setTimeout(
    	    	function() 
    	      {
    	      	location.reload();
    	      }, 0500);
    } else {
        //show box as normal
    }
    
}


function draw(canid, data1) {
	if(data1.length > 1){
	function change(time) {
	    var r = time.match(/^\s*([0-9]+)\s*-\s*([0-9]+)\s*-\s*([0-9]+)(.*)$/);
	    return r[3]+"-"+r[2]+"-"+r[1];
	}
    var canvas = document.getElementById(canid);
    var ctx = canvas.getContext('2d');
    ctx.font = "10px Arial";
    //define the grid for the graph
    var margin = 20;
    var lborder = 10;
    var rborder = 0;
    var displayHeight = canvas.height - (2 * margin);
    var displayWidth = canvas.width - (2 * margin) - lborder - rborder;
    var dataXVals = new Array();
    for(i = 0; i < data1.length; i++){ dataXVals.push(Number(data1[i].balance)); }
    dataXVals.sort(function(a,b){return a-b});
    var minVal = Number(dataXVals[0]);
    dataXVals.reverse(function(b,a){return b-a});
    if(Number(data1[0].target_balance) >= dataXVals[0])
    {
    	var maxVal = Number(data1[0].target_balance);
    }else
    {
    	var maxVal = Number(dataXVals[0]);
    }
    
    var stepSize = Math.ceil((maxVal-minVal)/10);
    minVal = minVal-stepSize;
    maxVal = maxVal+stepSize;
    //get date range from query and calculate number of days
    var endDate = new Date(data1[0].record_date);
    var startDate = new Date(data1[data1.length-1].record_date);
    var tDays = ((endDate.getTime()-startDate.getTime()) / (24*60*60*1000));
    var maxDate = startDate.getTime()+(24*60*60*1000*tDays);
    var stepDays = Math.ceil( tDays / (displayWidth/80) );
    var totalDays = (Math.ceil(tDays/stepDays) * stepDays);
    
    //define the intervals for x and y
    var xScalar = displayWidth / totalDays;
    var yScalar = (displayHeight / (maxVal - minVal));
    
    //create the graph background
    // print row header and draw horizontal grid lines
    ctx.strokeStyle = "rgba(125, 125, 255, 0.2)"; // light blue lines
    ctx.beginPath();
    // print  column header and draw vertical grid lines
    var month = (startDate.getMonth()+1).toString();
    var monthDay = startDate.getDate().toString();
    if(month.length == 1){month = "0"+month;}
    if(monthDay.length == 1){monthDay = "0"+monthDay;}
    var currDate = startDate.getFullYear() + "-" + month + "-" + monthDay;
    for (i = 0; i <= Math.ceil(totalDays/stepDays); i++) 
    {
        var x = (i) * xScalar * stepDays;
        ctx.fillText(currDate, x, canvas.height-margin+15);
        var nextDate = new Date(currDate).getTime() + (stepDays * (24*60*60*1000));
        currDate = new Date(nextDate);
        var month = (currDate.getMonth()+1).toString();
        var monthDay = currDate.getDate().toString();
        if(month.length == 1){month = "0"+month;}
        if(monthDay.length == 1){monthDay = "0"+monthDay;}
        currDate = currDate.getFullYear() + "-" + month + "-" + monthDay;
        ctx.moveTo(x+lborder+margin, margin);
        ctx.lineTo(x+lborder+margin, displayHeight+10);
    }
    // print row header and draw horizontal grid lines
    var count = 0;
    for (scale = maxVal; scale >= minVal; scale -= stepSize) {
        var y = margin + (yScalar * count * stepSize);
        ctx.fillText(scale.toFixed(2), (xScalar/4), y + 5);
        ctx.moveTo((margin+lborder), y);
        ctx.lineTo(displayWidth+margin+lborder, y);
        count++;
    }
    ctx.stroke();
    

    //plot the target Balance

    	var yVal = margin + (maxVal - Number(data1[0].target_balance)) * yScalar ;
    	ctx.beginPath();
        ctx.strokeStyle = "rgb(255,5,0)";
        ctx.moveTo((margin+lborder),yVal);
        ctx.lineTo(displayWidth+margin+lborder,yVal);
        ctx.stroke();

    

    //plot points into line graph        
    ctx.strokeStyle = "rgb(0,255,0)";
    // set a color and make one call to plotData()
    // for each data set
    plotData(data1);
                
    function plotData(dataSet) {
        ctx.beginPath();
        for (i = 0; i < dataSet.length; i++) {
            var day = new Date(data1[i].record_date);
            var xday = (day.getTime()-startDate.getTime())/(1000*60*60*24);
            ctx.lineTo((xday * xScalar)+lborder+margin, margin + (maxVal - Number(dataSet[i].balance)) * yScalar ); 
            console.log((margin + (maxVal - Number(dataSet[i].balance)) * yScalar )+" Balance");
        }
        //ctx.closePath();
        ctx.stroke();
    }
	}
}
