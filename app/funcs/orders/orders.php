<?php

function insertOrder($prod_id, $quantity, $g_unit_weight, $g_unit_price, $mcharges, $total_amount, $inv_id, $mor_id){
	$sql="INSERT INTO orders(order_id, product_id, quantity, unit_weight, g_unit_price, mcharges, unit_amount, inv_id, m_id) 
	VALUES ( null, $prod_id, $quantity, $g_unit_weight, $g_unit_price, $mcharges, $total_amount, $inv_id, ".$mor_id.")";
	executeSQL($sql);
	$order_id = getSingleValue("select max(order_id) from orders");
	return $order_id;	
}

function validateOrder(){
	return true;
}

function processOrder($type){
	$result=array();	
	$result = processProductsAndInsert($type);	
	if($result['isError']==true){
		return $result;
	}else{
		$total_amount=$result['totalAmount'];
		if($type!='mortage'){
			$status=null;
			$discount=$_POST['discount'];
			$order_status=$_POST['order_status'];
			$deposit=$_POST['deposit'];			
			$net_amount=$total_amount-$discount;
			$balance=$net_amount-$deposit;
			if($order_status==STATUS_DELIVERED_VALUE){
				if($balance==0){
					$status=STATUS_PAID_VALUE;
				}else{
					$status=STATUS_UNPAID_VALUE;
				}
			}else{
				$status=$order_status;
			}
			$inv_id=$result['id'];
			insertTransaction($inv_id, $total_amount, cheNull($discount), cheNull($net_amount), cheNull($deposit), cheNull($balance), cheSNull($status));
			$result['isError']=false;
		}else{
			$mor_id=$result['id'];			
			$extra=$_POST['extra_amount'];
			$perInterest=$_POST['monthlyInterest'];			
			$deposit=$_POST['deposit'];	
			$net_amount=$extra;
			$mInterest=($net_amount * ($perInterest/100));
			$balance=$net_amount;
			if($balance==0){
				$status=STATUS_PAID_VALUE;
			}else{
				$status=STATUS_UNPAID_VALUE;
			}
			updateMortageForTransaction($mor_id, $total_amount, cheNull($perInterest), cheNull($mInterest), cheNull($net_amount), cheNull($deposit), cheNull($balance), cheSNull($status));
			insertMortageTransaction($mor_id, cheSNull(MORTAGE_ACTION_ADD_FIRST_TIME), cheSNull(MORTAGE_COMMENTS_ADD_INTEREST), cheNull($net_amount));
			$result['isError']=false;
		}
	}
	return $result;
}

function processProductsAndInsert($type){	
	$result=array();
	$totalOrders=0;$total_amount=0;$inv_id=null;$mor_id=null;$cust_id=null;
	for($i=1;$i<=NO_OF_TICKETS;$i++){	
		$key="pname".$i;				
		if(strlen($_POST[$key])!=0 && is_numeric($_POST[$key])){			
			$prod_id=$_POST[$key];
			$quantity=$_POST['quan'.$i];
			$g_unit_weight=$_POST['weight'.$i];
			$g_unit_price=$_POST['price'.$i];
			$mcharges=null;
			$cust_id=$_POST['cname'];
			if(((is_null($cust_id) || strlen($cust_id) == 0)) 
				&& 
				(strlen($_POST['cnameNew']) > 0 ) 
			){
				$cust_id=prepareToInsertCustomer();
				if(!is_numeric($cust_id)){
					$result['isError']=true;
					$result['errMsg']=$cust_id;						
					return $result;
				}
			}					
			$unit_amount=floatval(($g_unit_weight * $g_unit_price));
			if($i==1){				
				if($type=='mortage'){
					$mor_id=insertMortage(cheNull($cust_id));
					
				}else{
					$inv_id=insertInvoice(cheNull($cust_id), cheNull(null));	
				}	
			}
			if(!is_null($inv_id) || !is_null($mor_id) ){
				$order_id = insertOrder($prod_id, $quantity, $g_unit_weight, $g_unit_price, cheNull($mcharges), $unit_amount, cheNull($inv_id), cheNull($mor_id));
				if(is_numeric($order_id)){
					$totalOrders++;
					$total_amount=$total_amount+$unit_amount;
				}
			}			
		}			
	}
	
	if($totalOrders==0 && (is_null($inv_id) || is_null($mor_id)) ){
		$result['isError']=true;
		$result['errMsg']="Number of Inserted Orders is empty ";		
	}else{
		$result['totalOrder']=$totalOrders;
		$result['totalAmount']=$total_amount;
		if($type=='mortage'){
			$result['id']=$mor_id;
		}else{
			$result['id']=$inv_id;
		}
		$result['isError']=false;		
	}	
	return $result;	
}

