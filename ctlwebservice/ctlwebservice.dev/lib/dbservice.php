<?php
require_once('../../hasdbchanged/changeutil.php');
class DBService extends DBBaseUtility
{
	public function __construct()
	{
	}
	public function storeCtlOperation(
		$randomrpcid,
		$operationtime,
		$operation /* varchar(20) */,
		$movement /* varchar(20) */,
		$unit /* varchar(20) */,
		$result /* varchar(20) */
	)
	{
		try {
			$this->p_init();
		}
		catch (Exception $e)
		{
		}
		try {
			$this->p_storeCtlOperation(
					$randomrpcid,
					$operationtime,
					$operation,
					$movement,
					$unit,
					$result);
		}
		catch (Exception $e)
		{
		}
		try {
			$this->p_uninit();
		}
		catch (Exception $e)
		{
		}

	}
	private function p_storeCtlOperation(
		$randomrpcid,
		$operationtime,
		$operation /* varchar(20) */,
		$movement /* varchar(20) */,
		$unit /* varchar(20) */,
		$result /* varchar(20) */
	)
	{ ///M
		$query1 = "INSERT INTO ctloperations ";
		$query1 .= "(randomrpcid,operationtime,operation,movement,unit,result) ";
		$query1 .= "VALUES (?,NOW(),?,?,?,?)";

		$stmt1 = $this->m_mysqli->prepare($query1);
		$stmt1->bind_param('sssss', $ran,$op,$move,$u,$res); 
		$ran = $randomrpcid;
		// TODO: maybe store 2 operation times - time on db - time
		// on soap service.
		// $otime = $operationtime;
		$op = $operation;
		$move = $movement;
		$u = $unit;
		$res = $result;

		$retExe = $stmt1->execute();
		// TODO: test whether or not error can be retrieved before close.
		$mysqlErrMsg = $stmt1->error;
		$stmt1->close();
		if ($retExe == FALSE)
		{
			throw new Exception("query1 failed:".$mysqlErrMsg);  // TODO: enhance
		}
	} ///N
}
?>
