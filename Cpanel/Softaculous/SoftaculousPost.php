<?php
namespace App\Phase\Cpanel\Softaculous;

class SoftaculousPost {
    public $softsubmit;
    public $softdomain;
    public $softdirectory;
    public $softdb;
    public $dbusername;
    public $dbuserpass;
    public $admin_username;
    public $admin_pass;
    public $admin_email;
    public $language;
    public $site_name;
    public $site_desc;
    public $noemail;
    public $datadir;
    public $overwrite_existing;
    public $removeins;
    public $remove_db;
    public $remove_dbuser;
    public $remove_datadir;
    public $remove_dir;
    public $admin_url;
    public $admin_fname;
    public $admin_lname;
    public $license_key;

    /**
     * @return mixed
     */
    public function getSoftsubmit()
    {
        return $this->softsubmit;
    }

    /**
     * @param mixed $softsubmit
     */
    public function setSoftsubmit($softsubmit)
    {
        $this->softsubmit = $softsubmit;
    }

    /**
     * @return mixed
     */
    public function getSoftdomain()
    {
        return $this->softdomain;
    }

    /**
     * @param mixed $softdomain
     */
    public function setSoftdomain($softdomain)
    {
        $this->softdomain = $softdomain;
    }

    /**
     * @return mixed
     */
    public function getSoftdirectory()
    {
        return $this->softdirectory;
    }

    /**
     * @param mixed $softdirectory
     */
    public function setSoftdirectory($softdirectory)
    {
        $this->softdirectory = $softdirectory;
    }

    /**
     * @return mixed
     */
    public function getSoftdb()
    {
        return $this->softdb;
    }

    /**
     * @param mixed $softdb
     */
    public function setSoftdb($softdb)
    {
        $this->softdb = $softdb;
    }

    /**
     * @return mixed
     */
    public function getDbusername()
    {
        return $this->dbusername;
    }

    /**
     * @param mixed $dbusername
     */
    public function setDbusername($dbusername)
    {
        $this->dbusername = $dbusername;
    }

    /**
     * @return mixed
     */
    public function getDbuserpass()
    {
        return $this->dbuserpass;
    }

    /**
     * @param mixed $dbuserpass
     */
    public function setDbuserpass($dbuserpass)
    {
        $this->dbuserpass = $dbuserpass;
    }

    /**
     * @return mixed
     */
    public function getAdminUsername()
    {
        return $this->admin_username;
    }

    /**
     * @param mixed $admin_username
     */
    public function setAdminUsername($admin_username)
    {
        $this->admin_username = $admin_username;
    }

    /**
     * @return mixed
     */
    public function getAdminPass()
    {
        return $this->admin_pass;
    }

    /**
     * @param mixed $admin_pass
     */
    public function setAdminPass($admin_pass)
    {
        $this->admin_pass = $admin_pass;
    }

    /**
     * @return mixed
     */
    public function getAdminEmail()
    {
        return $this->admin_email;
    }

    /**
     * @param mixed $admin_email
     */
    public function setAdminEmail($admin_email)
    {
        $this->admin_email = $admin_email;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getSiteName()
    {
        return $this->site_name;
    }

    /**
     * @param mixed $site_name
     */
    public function setSiteName($site_name)
    {
        $this->site_name = $site_name;
    }

    /**
     * @return mixed
     */
    public function getSiteDesc()
    {
        return $this->site_desc;
    }

    /**
     * @param mixed $site_desc
     */
    public function setSiteDesc($site_desc)
    {
        $this->site_desc = $site_desc;
    }

    /**
     * @return mixed
     */
    public function getNoemail()
    {
        return $this->noemail;
    }

    /**
     * @param mixed $noemail
     */
    public function setNoemail($noemail)
    {
        $this->noemail = $noemail;
    }

    public function setDataDir($datadir)
    {
        $this->datadir = $datadir;
    }

    public function setKeyValue($key, $val)
    {
        $this->$key = $val;
    }

    /**
     * @return mixed
     */
    public function getoverwrite_existing()
    {
        return $this->overwrite_existing;
    }

    /**
     * @param mixed
     */
    public function setoverwrite_existing($overwrite_existing)
    {
        $this->overwrite_existing = $overwrite_existing;
    }

    /**
     * @return mixed
     */
    public function getremoveins()
    {
        return $this->removeins;
    }

    /**
     * @param mixed 
     */
    public function setremoveins($removeins)
    {
        $this->removeins = $removeins;
    }

    /**
     * @return mixed
     */
    public function getremove_dir()
    {
        return $this->remove_dir;
    }

    /**
     * @param mixed 
     */
    public function setremove_dir($remove_dir)
    {
        $this->remove_dir = $remove_dir;
    }

    /**
     * @return mixed
     */
    public function getremove_db()
    {
        return $this->remove_db;
    }

    /**
     * @param mixed 
     */
    public function setremove_db($remove_db)
    {
        $this->remove_db = $remove_db;
    }

    /**
     * @return mixed
     */
    public function getremove_dbuser()
    {
        return $this->remove_dbuser;
    }

    /**
     * @param mixed 
     */
    public function setremove_dbuser($remove_dbuser)
    {
        $this->remove_dbuser = $remove_dbuser;
    }

    /**
     * @return mixed
     */
    public function getremove_datadir()
    {
        return $this->remove_datadir;
    }

    /**
     * @param mixed 
     */
    public function setremove_datadir($remove_datadir)
    {
        $this->remove_datadir = $remove_datadir;
    }

    /**
     * @return mixed
     */
    public function getAdminDir()
    {
        return $this->admin_url;
    }

    /**
     * @param mixed 
     */
    public function setAdminDir($admin_url)
    {
        $this->admin_url = $admin_url;
    }

    /**
     * @return mixed
     */
    public function getAdminFirstName()
    {
        return $this->admin_fname;
    }

    /**
     * @param mixed 
     */
    public function setAdminFirstName($admin_fname)
    {
        $this->admin_fname = $admin_fname;
    }

    /**
     * @return mixed
     */
    public function getAdminLastName()
    {
        return $this->admin_lname;
    }

    /**
     * @param mixed 
     */
    public function setAdminLastName($admin_lname)
    {
        $this->admin_lname = $admin_lname;
    }

    /**
     * @return mixed
     */
    public function getLicenseKey()
    {
        return $this->license_key;
    }

    /**
     * @param mixed 
     */
    public function setLicenseKey($license_key)
    {
        $this->license_key = $license_key;
    }
}