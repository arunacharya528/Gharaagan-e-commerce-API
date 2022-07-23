<?php

use App\Models\SiteDetail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('value');
            $table->timestamps();
        });

        $defaultSiteData = [
            [
                'name' => 'site_address',
                'value' => '<div>Gharagan</div><div>Location</div><div>Address</div>'
            ],
            [
                'name' => 'logo_url',
                'value' => "https://www.dropbox.com/s/zsc8uo5nsdnbzji/logo%20100x100.png?raw=1"
            ],
            [
                'name' => 'lg_logo_url',
                'value' => "https://www.dropbox.com/s/cfz9yxge2u5svmk/lg-logo%20200x100.png?raw=1"
            ],
            [
                'name' => 'notification',
                'value' => "-"
            ],
            [
                'name' => 'social_links',
                'value' => <<<EOD
                            [
                              {
                                "path": "https://facebook.com"
                              },
                              {
                                "path": "https://twitter.com"
                              },
                              {
                                "path": "https://youtube.com"
                              }
                            ]
                            EOD
            ]
        ];

        SiteDetail::insert($defaultSiteData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_details');
    }
}
