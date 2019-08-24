<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
header ( 'Content-type: application/json' );

use Illuminate\Support\Facades\Crypt;


if (isset($_REQUEST['api_req'])) {

    $api_req = $_REQUEST['api_req'];

    if ($api_req == 'Login') {
        if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $user_id  = 0;

            $encrypted = Crypt::encryptString($password);

            $employees = \App\User::select('*')
                ->where('email',$username)
                ->get();


            foreach ($employees as $employee) {
                if (Hash::check($password,$employee->password)) {
                    $user_id = $employee->id;
                }
            }

            if ($user_id == 0) {
                $data_to_send = json_encode(['status'=>'Not Found','details'=>'']);
            } else {
                $data = array('user_id'=>$user_id);
                $data_to_send = json_encode(['status'=>'User Found','details'=>$data]);
            }

            echo $data_to_send;
        }
    }


    else if ($api_req == 'listGroups') {
        if (isset($_REQUEST['user_id'])) {
            $user_id = $_REQUEST['user_id'];

            $employees = \App\User::select('*')
                ->where('id',$user_id)
                ->get();

            $countUsers = count($employees);

            if ($countUsers == 0) {
                $data_to_send = json_encode(['status'=>'Not Found','details'=>'']);
                echo $data_to_send;
            } else {
                $groups = \App\Group::select('*')
                    ->where('created_by',$user_id)
                    ->get();

                $groupList = array();
                foreach ($groups as $group) {
                    $kiosk = array('id'=>$group->id,'group_name'=>$group->name,'group_descrption'=>$group->description);
                    array_push($groupList,$kiosk);
                }

                $data_to_send = json_encode(['status'=>'Groups Found','details'=>$groupList]);
                echo $data_to_send;
            }
        }
    }


    else if ($api_req == 'newGroup') {
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['name']) && isset($_REQUEST['description'])) {
            $user_id = $_REQUEST['user_id'];
            $name = $_REQUEST['name'];
            $description = $_REQUEST['description'];


            $employees = \App\User::select('*')
                ->where('id', $user_id)
                ->get();

            $countUsers = count($employees);

            if ($countUsers == 0) {
                $data_to_send = json_encode(['status' => 'Not Found', 'details' => '']);
                echo $data_to_send;
            } else {
                $groups = \App\Group::create([
                    'name'=>$name,
                    'description'=>$description,
                    'created_by'=>$user_id
                ]);

                $groups = \App\Group::select('*')
                    ->where('created_by',$user_id)
                    ->get();

                $groupList = array();
                foreach ($groups as $group) {
                    $kiosk = array('id'=>$group->id,'group_name'=>$group->name,'group_descrption'=>$group->description);
                    array_push($groupList,$kiosk);
                }

                $data_to_send = json_encode(['status'=>'Group Added','details'=>$groupList]);
                echo $data_to_send;
            }
        }
    }

    else if ($api_req == 'deleteGroup') {
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['group_id']) ) {
            $user_id = $_REQUEST['user_id'];
            $group_id = $_REQUEST['group_id'];


            $employees = \App\User::select('*')
                ->where('id', $user_id)
                ->get();

            $countUsers = count($employees);

            if ($countUsers == 0) {
                $data_to_send = json_encode(['status' => 'Not Found', 'details' => '']);
                echo $data_to_send;
            } else {

                $groups2 = \App\Group::select('*')
                    ->where('id',$group_id)
                    ->get();

                $groupsEmployee = \App\Employee::select('*')
                    ->where('group_id',$group_id)
                    ->get();

                if (count($groups2) > 0) {
                    $findGroup = \App\Group::find($group_id);
                    $findGroup->delete();
                }

                if (count($groupsEmployee) > 0) {
                    $findEmployee = \App\Employee::where('group_id',$group_id);
                    $findEmployee->delete();
                }


                $groups = \App\Group::select('*')
                    ->where('created_by',$user_id)
                    ->get();

                $groupList = array();
                foreach ($groups as $group) {
                    $kiosk = array('id'=>$group->id,'group_name'=>$group->name,'group_descrption'=>$group->description);
                    array_push($groupList,$kiosk);
                }

                $data_to_send = json_encode(['status'=>'Group Removed','details'=>$groupList]);
                echo $data_to_send;
            }
        }
    }


    else if ($api_req == 'addEmployee') {
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['group_id']) && isset($_REQUEST['name'])) {
            $user_id = $_REQUEST['user_id'];
            $name = $_REQUEST['name'];
            $group_id = $_REQUEST['group_id'];


            $employees = \App\User::select('*')
                ->where('id', $user_id)
                ->get();

            $countUsers = count($employees);

            if ($countUsers == 0) {
                $data_to_send = json_encode(['status' => 'Not Found', 'details' => '']);
                echo $data_to_send;
            } else {
                $groups = \App\Employee::create([
                    'name'=>$name,
                    'group_id'=>$group_id,
                    'created_by'=>$user_id
                ]);

                $groups = \App\Employee::select('*')
                    ->where('created_by',$user_id)
                    ->get();

                $groupList = array();
                foreach ($groups as $group) {
                    $kiosk = array('id'=>$group->id,'Employee_name'=>$group->name,'employee_group'=>$group->group_id);
                    array_push($groupList,$kiosk);
                }

                $data_to_send = json_encode(['status'=>'Employee Added','details'=>$groupList]);
                echo $data_to_send;
            }
        }
    }


    else if ($api_req == 'listEmployee') {
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['group_id'])) {
            $user_id = $_REQUEST['user_id'];
            $group_id = $_REQUEST['group_id'];


            $employees = \App\User::select('*')
                ->where('id', $user_id)
                ->get();

            $countUsers = count($employees);

            if ($countUsers == 0) {
                $data_to_send = json_encode(['status' => 'Not Found', 'details' => '']);
                echo $data_to_send;
            } else {


                $groups = \App\Employee::select('*')
                    ->where('created_by',$user_id)
                    ->get();

                $groupList = array();
                foreach ($groups as $group) {
                    $kiosk = array('id'=>$group->id,'Employee_name'=>$group->name,'employee_group'=>$group->group_id);
                    array_push($groupList,$kiosk);
                }

                $data_to_send = json_encode(['status'=>'Employee List','details'=>$groupList]);
                echo $data_to_send;
            }
        }
    }


    else if ($api_req == 'deleteEmployee') {
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['employee_id']) ) {
            $user_id = $_REQUEST['user_id'];
            $employee_id = $_REQUEST['employee_id'];


            $employees = \App\User::select('*')
                ->where('id', $user_id)
                ->get();

            $countUsers = count($employees);

            if ($countUsers == 0) {
                $data_to_send = json_encode(['status' => 'Not Found', 'details' => '']);
                echo $data_to_send;
            } else {

                $groups2 = \App\Employee::select('*')
                    ->where('id',$employee_id)
                    ->get();


                if (count($groups2) > 0) {
                    $findGroup = \App\Employee::find($employee_id);
                    $findGroup->delete();
                }


                $groups = \App\Employee::select('*')
                    ->where('created_by',$user_id)
                    ->get();

                $groupList = array();
                foreach ($groups as $group) {
                    $kiosk = array('id'=>$group->id,'Employee_name'=>$group->name,'employee_group'=>$group->group_id);
                    array_push($groupList,$kiosk);
                }


                $data_to_send = json_encode(['status'=>'Employee Removed','details'=>$groupList]);
                echo $data_to_send;
            }
        }
    }


    else if ($api_req == 'editEmployee') {
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['employee_id']) && isset($_REQUEST['group_id']) ) {
            $user_id = $_REQUEST['user_id'];
            $employee_id = $_REQUEST['employee_id'];
            $group_id = $_REQUEST['group_id'];


            $employees = \App\User::select('*')
                ->where('id', $user_id)
                ->get();

            $countUsers = count($employees);

            if ($countUsers == 0) {
                $data_to_send = json_encode(['status' => 'Not Found', 'details' => '']);
                echo $data_to_send;
            } else {

                $groups2 = \App\Employee::select('*')
                    ->where('id',$employee_id)
                    ->get();


                if (count($groups2) > 0) {
                    $findGroup = \App\Employee::where('id',$employee_id)
                    ->update([
                        'group_id'=>$group_id
                    ]);
                }


                $groups = \App\Employee::select('*')
                    ->where('created_by',$user_id)
                    ->get();

                $groupList = array();
                foreach ($groups as $group) {
                    $kiosk = array('id'=>$group->id,'Employee_name'=>$group->name,'employee_group'=>$group->group_id);
                    array_push($groupList,$kiosk);
                }


                $data_to_send = json_encode(['status'=>'Employee Group Changed','details'=>$groupList]);
                echo $data_to_send;
            }
        }
    }


}


?>