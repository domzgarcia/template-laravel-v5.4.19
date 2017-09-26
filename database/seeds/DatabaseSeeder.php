<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        Model::unguard();
        DB::table('users')->truncate();

        /*|============================
          | Default Users
          |============================ 
        */
        $defaultUsers = array(
						array(
							'name'=>'Admin Project',
							'email' => 'admin@domain.com',
							'role_id' => 1,
							'password' => bcrypt('password'),
							'created_at' => date("Y-m-d H:i:s"),
							'updated_at' => date("Y-m-d H:i:s"),
						),
						array(
							'name'=>'Editor Project',
							'email' => 'editor@domain.com',
							'role_id' => 2,
							'password' => bcrypt('password'),
							'created_at' => date("Y-m-d H:i:s"),
							'updated_at' => date("Y-m-d H:i:s")
						),
						array(
							'name'=>'Moderator Project',
							'email' => 'moderator@domain.com',
							'role_id' => 3,
							'password' => bcrypt('password'),
							'created_at' => date("Y-m-d H:i:s"),
							'updated_at' => date("Y-m-d H:i:s")
						)
					);
        
        DB::table('users')->insert($defaultUsers);

        /*|============================
          | Default Role
          |============================ 
        */

        DB::table('roles')->truncate();

        Role::create([
            'name'          => 'Administrators',
            'description'   => 'Complete access to the CMS (all management modules).'
        ]);
        Role::create([
            'name'          => 'Editors',
            'description'   => 'Manage website page contents.'
        ]);
        Role::create([
            'name'          => 'Moderators',
            'description'   => 'Monitor/extract customers’ submissions/requests and updates the status of inquiries '
        ]);

    }	
}
