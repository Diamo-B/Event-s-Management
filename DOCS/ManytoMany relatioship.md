# OneToMany relationship

let's take an example with two tables : user and role

The user can have one role, but a role can be asigned to multiple users

### users migration

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->bigInteger('role_id')->unsigned()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles')
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
```

### user's model

```php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Many to Many relationship with invitation class using belongsToMany()
    public function invitations()
    {
        return $this->belongsToMany(invitation::class);
    }
}
```

### invitations migration

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("object");
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitations');
    }
};
```

### invitation's model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invitation extends Model
{
    use HasFactory;

    public $timestamps = false; //by default timestamp true
    public function setCreatedAtAttribute($value) { 
        $this->attributes['created_at'] = \Carbon\Carbon::now(); 
    }
    protected $guarded = [];  

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
```

to link eveything we need to create a pivot table :

+ install the following package: `composer require josezenem/laravel-make-migration-pivot`

+ call the make:pivot command: `php artisan make:pivot [model1] [model2]`

In our case:

`php artisan make:pivot invitation User`

this will generate a migration named in the following format: `year_month_day_migrationNumber_create_[model-1]_[model-2]_pivot_table.php`

!!!! erase everything in the `Schema::create(){}` function then replace it with the following code with the appropriate changes according to your model:

```php
<?php

use App\Models\User;
use App\Models\invitation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('invitation_user', function (Blueprint $table) {
          $table->foreignId('invitation_id')->constrained('invitations');
          $table->foreignId('user_id')->constrained('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitation_user');
    }
};
```

then apply the migrations using the `php artisan migrate` command

---

## making a data relationship with eloquent

#### putting some data in our tables to work with:

+ Users
  
  ```php
  use Carbon\Carbon
  $user = new User(['firstName'=>'Bachar','lastName'=>'Elkarni',
  'email'=>'elkarni.bachar@gmail.com','password'=>Hash::make('azerty123')]);
  $user1 = new User(['firstName'=>'diamo','lastName'=>'keiden',
  'email'=>'sdsf@gmail.com','password'=>Hash::make('azerty123')])
  ```

> Output:
> 
> => App\Models\User {#4544 
> 
>  id: 1,
>  firstName: "Bachar",
>  lastName: "Elkarni",
>  email: "elkarni.bachar@gmail.com",
> #password:"2y$10x0x.HV222DxS58GCGx0RHeYEGO15rZcmG.aBJT"
> 
>    }
> 
> => App\Models\User {#4545
> 
>  id: 2,
>  firstName: "diamo",
>  lastName: "keiden",
>  email: "sdsf@gmail.com",
>  #password: "2y$10x0x.HV222DxS58GCGx0RHeYEGO15rZcmG.aBJT"
> 
>    }

        Let's save them to the database:

```php
$user->save();
$user1->save();
```

> Output:
> 
> => true
> 
> =>true

- invitation

```php
    $invitation = new invitation(['title'=>'git',
                   'object'=>'this is an intro to git']);
```

> Output:
> 
>  App\Models\invitation {#4507
>      id: 1,
>      title: "git",
>      object: "this is an intro to git",
>    }

Let's save it to the database:

```php
$invitation->save();
```

> Output:
> 
> => true

### making the ManyToMany relationship

To make the actual relationship between the records we need to attach one to another.

As an example let's attach our two users to our invitation:

```php
$invitation->users()->attach([$user,$user1]);
/* 
users is the function we defined in the invitation's model
to handle the actual belongsToMany relationship
*/
```

> Output.
> 
> => null

### Fetching data using the ManyToMany relationship

we can fetch all the users that belongs to the invitation in the following way:

```php
$invitation->users()->get(); 
// or the first user only using first() instead of get()
```

> Output:
> 
> Illuminate\Database\Eloquent\Collection {#4517
>      all: [
>        App\Models\User {#4497
>          id: 1,
>          firstName: "bachar",
>          lastName: "Elkarni",
>          email: "elkarni.bachar@gmail.com",
>          email_verified_at: null,
>          #password:"2y$10x0x.HV222DxS58GCGx0RHeYEGO15rZcmG.aBJT"
>          #remember_token: null,
>          created_at: "2022-07-16 13:02:00",
>          updated_at: "2022-07-16 13:02:00",
>          pivot: Illuminate\Database\Eloquent\Relations\Pivot {#4488
>            invitation_id: 1,
>            user_id: 1,
>          },
>        },
> 
>  App\Models\User {#4499
>          id: 2,
>          firstName: "diamo",
>          lastName: "keiden",
>          email: "sdsf@gmail.com",
>          email_verified_at: null,
>          #password: "2y$10x0x.HV222DxS58GCGx0RHeYEGO15rZcmG.aBJT",
>          #remember_token: null,
>          created_at: "2022-07-16 13:02:03",
>          updated_at: "2022-07-16 13:02:03",
>          pivot: Illuminate\Database\Eloquent\Relations\Pivot {#4514
>            invitation_id: 1,
>            user_id: 2,
>          },
>        },
>      ],
>    }

### Filtering fetched data using the ManyToMany relationship

we can filter the data fetched using the pivot table in the following way

```php
$invitation->users()->where('firstName','diamo')->get();
```

> Output:
> 
> => Illuminate\Database\Eloquent\Collection {#4523
>      all: [
>        App\Models\User {#4529
>          id: 2,
>          firstName: "diamo",
>          lastName: "keiden",
>          email: "sdsf@gmail.com",
>          email_verified_at: null,
>          #password: "2y$10x0x.HV222DxS58GCGx0RHeYEGO15rZcmG.aBJT",
>          #remember_token: null,
>          created_at: "2022-07-16 13:02:03",
>          updated_at: "2022-07-16 13:02:03",
>          pivot: Illuminate\Database\Eloquent\Relations\Pivot {#4501
>            invitation_id: 1,
>            user_id: 2,
>          },
>        },
>      ],
>    }

#### What if we need more filtering???

like what if we need to retrieve the first and last names of the user that has an email equal to : "sdsf@gmail.com" from an invitation?

```php
$invitation->users()->where('firstName','diamo')->get()[0]->email;
```

> Output:
> 
> "sdsf@gmail.com"

**P.S: In a view you can simply use a foreach loop : foreach ($invitation->users()->get() as user) {user->email}**
