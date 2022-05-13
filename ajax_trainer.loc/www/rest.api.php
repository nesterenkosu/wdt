<? 
 require_once("$_SERVER[DOCUMENT_ROOT]/../includes/flight/Flight.php");
 require_once("$_SERVER[DOCUMENT_ROOT]/../db/dal.inc.php");
  
 function CreateUser() {
	 DBCreateUser(
		Flight::request()->data["Name"],
		Flight::request()->data["Email"],
		Flight::request()->data["Age"]
	);
 }
 Flight::route('PUT /rest/user',"CreateUser");
 
 function ReadUser($id) {
	Flight::json(DBGetUser($id));
 }
 Flight::route('GET /rest/user\?id=@id',"ReadUser");
 
 function ReadUsers() {
	$data=Array();

	while($row=DBFetchUser()) 	
		$data[]=Array($row["Name"],$row["Email"],$row["Age"]);

	//Отправка данных клиенту в формате JSON (JavaScript Object Notation)
	Flight::json($data);
	
 }
 Flight::route('POST /rest/users',"ReadUsers");
 
 function UpdateUser() {
	 DBUpdateUser(
		Flight::request()->data["ID"],
		Flight::request()->data["Name"],
		Flight::request()->data["Email"],
		Flight::request()->data["Age"]
	);
 }
 Flight::route('PATCH /rest/user',"UpdateUser");
 
 function DeleteUser($id) {
	 DBDeleteUser($id);
 }
 Flight::route('DELETE /rest/user\?id=@id',"DeleteUser"); 

 Flight::start();
