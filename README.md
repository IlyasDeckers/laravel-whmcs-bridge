# laravel whmcs bridge

This package is build as a bridge between Laravel and WHMCS. Giving you the freedom of developing your own client interface and server modules outside of WHMCS. This package provides a fluent API.

Requirements:
- laravel
- cPanel
- WHMCS
- Softaculous

** Attention!! **
This project is far from finished, please come back in a couple of weeks, it is goingto be sweet ;)

## Instalation
...

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
