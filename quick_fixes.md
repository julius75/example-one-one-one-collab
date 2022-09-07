
**** 
##### create users (this was based on kisii county data)

quick note on this though: the titles are fetched from a config in users you'll need to probably ensure that 
your titles are indeed in the config array
```php
$users = [
            ["Hon. Sarah Omache","County Executive Committee Member - Health",254702560801,"pacepbs@yahoo.com","County Health Management Team","county hms managers","9TRMd"  ],
            ["Ms. Alice Abuki","County Chief Officer - Health",254721306687,"aliceabuki@yahoo.com","County Health Management Team","county hms managers","9TRMd"  ],
        ];

        $bar = $this->output->createProgressBar(count($users));

        $bar->start();

        $roles = [
            ["name" => "county hms managers", "description" => "County Health Management Team"],
            ["name" => "county covid-19 committee", "description" => "County COVID-19 Committee Members"],
            ["name" => "quarantine facility manager", "description" => "Manager (Treatment, Quarantine and Isolation Facilities)"],
            ["name" => 'quarantine facility admission officer', "description" => "Addmission Officer (Treatment, Quarantine and Isolation Facilities)"],
            ["name" => "field clinician", "description" => "Field clinician"],
            ["name" => "system admin", "description" => "System administrator"],
        ];

        foreach ($roles as $role) {
            $role = \Ignite\Users\Entities\Role::updateOrCreate($role);
        }


       foreach($users as $index => $user_data) {
           if($index < 1) {
               $names_array = explode(' ', $user_data[0]);

               $user = \Ignite\Users\Entities\User::updateOrCreate(['username' => $names_array[count($names_array) - 1],
                   'email' => $user_data[3]],
                   [
                   'password' => bcrypt($user_data[6]),
                   'active' => true,
               ]);

               $user->profile()->create([
                   "title" => array_search($names_array[0], mconfig('users.users.titles')),
                   "first_name" => $names_array[1],
                   "last_name" => $names_array[count($names_array) - 1],
                   "job_description" => $user_data[1],
                   "phone" => $user_data[2],
               ]);

               $role_id = \Ignite\Users\Entities\Role::whereName($user_data[5])->first()->id;

               $user->attachRoles(['sudo']);

               $basic_permissions = [
                   'users.index', 'users.update', 'users.profile-info', 'users.profile-credentials', 'users.password-reset'
               ];

               foreach($basic_permissions as $permission) {
                   $user->hasPermission($permission) ? $user->detachPermission($permission) : $user->attachPermission($permission);
               }

               if($user_data[5] != 'field clinician') {
                   $user->clinics()->sync(\Ignite\Settings\Entities\Clinics::all()->pluck("id"));

                   $user->regions()->sync(\Ignite\Settings\Entities\Regions::all()->pluck("id"));
               }
           }

           $bar->advance();
       }

        $bar->finish();
```

#### database refresh: more of what system:reset does;
````php 
SET FOREIGN_KEY_CHECKS = 0; 
TRUNCATE table reception_patients; 
TRUNCATE table reception_patients_nok; 
TRUNCATE table evaluation_visits; 
TRUNCATE table inpatient_admissions; 
TRUNCATE table inpatient_admission_requests; 
TRUNCATE table evaluation_requested_samples; 
TRUNCATE table evaluation_sample_investigations; 
TRUNCATE table reception_contact_tracing_details; 
TRUNCATE table reception_contact_tracings; 
TRUNCATE table reception_contact_trackees; 
TRUNCATE table evaluation_investigations; 
TRUNCATE table evaluation_investigation_results; 
TRUNCATE table evaluation_investigation_result_details; 
TRUNCATE table evaluation_investigation_approvals; 
TRUNCATE table evaluation_prescriptions; 
TRUNCATE table evaluation_prescription_payments; 
TRUNCATE table evaluation_vitals; 
TRUNCATE table inventory_stock_movements; 
SET FOREIGN_KEY_CHECKS = 1;

``````

###### create facility and regions

```php   

// excel format: number, region, facility_name, keph_level, type
$facilities = [
    [150,"South Mugirango","Bombure Dispensary","Level 2","Dispensary"  ]
];

$bar = $this->output->createProgressBar(count($facilities));

$bar->start();

foreach($facilities as $facility)
{
  $region = \Ignite\Settings\Entities\Regions::firstOrCreate (['name' => $facility[1]]);

  $data = [
      "practice" => 1,
      "name" => $facility[2],
      "address" => 'n/s',
      "town" => $facility[1],
      "region_id" => $region->id,
      "location" => $facility[1],
      "street" => $facility[1],
      "building" =>  $facility[1],
      "office" => $facility[1],
      "status" => 'active',
      "type" => $facility[4],
      'keph_level' => $facility[3]
  ];

  \Ignite\Settings\Entities\Clinics::create($data);

  $bar->advance();
}

$bar->finish();
```
##### fresh products upload with category and units on excel

```php
$products = [
    ["NM18TAP011","MUAC Tape, Mid Upper Arm Circumference Adult","EQUIPMENT","Piece","  77.00 "  ],
    ["NM15EQP010","Wheel Chair","EQUIPMENT","Unit","  10,000.00 "  ]
];

$bar = $this->output->createProgressBar(count($products));

$bar->start();

/*
 *  for fresh setup:
 * SET FOREIGN_KEY_CHECKS = 0;
 * truncate inventory_products;
 * truncate inventory_store_products;
 * truncate inventory_categories;
 * truncate inventory_units;
 * SET FOREIGN_KEY_CHECKS = 1;
 * */

foreach($products as $product)
{
    $category = \Ignite\Inventory\Entities\InventoryCategories::firstOrCreate([
       'name' => $product[2]
    ]);

    $unit = \Ignite\Inventory\Entities\InventoryUnits::firstOrCreate([
        'name' => $product[3],
    ], ['symbol' => $product[3]]);


    \Ignite\Inventory\Entities\InventoryProducts::create([
        "name" => $product[1],
        "description" => '',
        "category" => $category->id,
        "unit" => $unit->id,
        "tax_category" => 1,
        "active" => 1,
    ]);

    $bar->advance();
}

$bar->finish();
}
```
##### store products and stores: create main store first
```php
        $clinics = \Ignite\Settings\Entities\Clinics::all();

        echo "Onto other stores \n";

        $bar = $this->output->createProgressBar(count($clinics) * count($products));

        $bar->start();

        foreach($clinics as $clinic) {
            $store = \Ignite\Inventory\Entities\Store::updateOrCreate([
                'name' => $clinic->name . ' store',
                "department_id" => 8,
                "facility_id" => $clinic->id,
                "parent_store_id" => $main_store->id,
                "main_store" => false,
                "delivery_store" => $main_store->id,
                "can_update_product_prices" => true,
                "can_order_from_suppliers" => true,
                "open_time" => null,
                "close_time" => null
            ]);

            foreach($products as $product) {
                \Ignite\Inventory\Entities\StoreProduct::updateOrCreate([
                    'store_id' => $store->id,
                    'product_id' => $product->id,
                    'quantity' => 0,
                    'selling_price' => $products_list[$product->id - 1][4],
                    'insurance_price' => $products_list[$product->id - 1][4],
                    're_order_level' => 0,
                    'unit_cost' => $products_list[$product->id - 1][4],
                    'total_cost' => 0,
                    'total_insurance_price' => 0,
                    'total_cash_price' => 0
                ]);

                $bar->advance();
            }
        }

        $bar->finish();
```
