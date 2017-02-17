# laravel whmcs bridge

This package is build as a bridge between Laravel and WHMCS. Giving you the freedom of developing your own client interface and server modules outside of WHMCS. This package provides a fluent API.

Requirements:
- laravel
- cPanel
- WHMCS
- Softaculous

**Attention!!**
This project is far from finished, please come back in a couple of weeks, it is goingto be sweet ;)

## Instalation

### Automaic
Not possible at the moment

### Manual
Copy this repo to your app folder.

add th' following service providers to config/app.php

```php
        App\Phase\Support\SupportServiceProvider::class,
        App\Phase\Billing\BillingServiceProvider::class,
        App\Phase\Whmcs\WhmcsServiceProvider::class,
        App\Phase\Api\ApiServiceProvider::class,
        App\Phase\Company\CompanyServiceProvider::class,
        App\Phase\Admin\AdminServiceProvider::class,
        App\Phase\Servers\ServerServiceProvider::class,
        App\Phase\Cpanel\CpanelServiceProvider::class,
        App\Phase\Notifications\NotificationsServiceProvider::class,
        App\Phase\Docs\DocsServiceProvider::class,

```
And register the Facedes
```php
        'Support' => App\Phase\Facades\Support::class,
        'Billing' => App\Phase\Facades\Billing::class,
        'Mollie' => Mollie\Laravel\Facades\Mollie::class,
        'Whmcs' => App\Phase\Facades\Whmcs::class,
        'Company' => App\Phase\Facades\Company::class,
        'Api' => App\Phase\Facades\Api::class,
        'Admin' => App\Phase\Facades\Admin::class,
        'Servers' => App\Phase\Facades\Servers::class,
        'Cpanel' => App\Phase\Facades\Cpanel::class,
        'Notifications' => App\Phase\Facades\Notifications::class,
        'Docs' => App\Phase\Facades\Docs::class,
```

## Usage

```php
    public function getRecords(Request $r)
    {
        $data = array(
            'hostname'  => $r['hostname'],
            'username'  => $r['username'],
            'domain'    => $r['domain']
        );

        $result = Cpanel::listDnsRecords($data);

        if($r->ajax()){
            return Response::json($result);
        }

        return Response::json($result->data);
    }
```
