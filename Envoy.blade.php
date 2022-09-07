@servers(['local' => '127.0.0.1'])

@setup
$folder = isset($folder) ? $folder : '~/Sites/platform';
$modules = [
'Core',
'Cafeteria',
'Dialysis',
'Users',
'Reception',
'Evaluation',
'Finance',
'Inpatient',
'Inventory',
'Reports',
'Hr',
'Settings',
'Sms',
'Theatre',
'Sync'
];
$branch = isset($branch) ? $branch : "master";
@endsetup

@story('update_local')
update_local_setup
update_local_modules
run_composer_on_local
@endstory

@task('update_local_setup', ['on' => 'local'])

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>'
echo 'Platform'
echo '------------------------------------------'
cd {{ $folder }}
git checkout -b {{ $branch }}

@endtask

@task('update_local_modules', ['on' => 'local'])

@if(count($modules) > 0)

    @foreach($modules as $item)
        echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>'
        echo 'Module: {{ $item }}'
        echo '------------------------------------------'
        cd {{ $folder }}/Modules/{{ $item }}
        pwd
        echo 'Doing that on  -- {{ $item }}'
        git checkout -b {{ $branch }}
        echo '------------------------------------------'
        echo "done"
        cd {{ $folder }}
    @endforeach

@endif

@endtask
