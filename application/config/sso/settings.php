<?php


$config = [];
$compnay_url = $_SERVER['HTTP_HOST'];
if ($compnay_url == 'localhost') {
    $path =  $_SERVER['USER_PORTAL_BASE_URL'];
} else {
    $path =  "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['USER_PORTAL_BASE_URL'];
}


$config['default'] = array(
    // If 'strict' is True, then the PHP Toolkit will reject unsigned
    // or unencrypted messages if it expects them signed or encrypted
    // Also will reject the messages if not strictly follow the SAML
    // standard: Destination, NameId, Conditions ... are validated too.
    'strict'  => true,

    // Enable debug mode (to print errors)
    'autologin' => false,
    'debug' => true,
    'showloginbox' => true,

    // Set a BaseURL to be used instead of try to guess
    // the BaseURL of the view that process the SAML Message.
    // Ex. http://sp.example.com/
    //     http://example.com/sp/
    'baseurl' => null,

    // Service Provider Data that we are deploying
    'sp'      => array(
        // Identifier of the SP entity  (must be a URI)
        'entityId'                  => '',
        // Specifies info about where and how the <AuthnResponse> message MUST be
        // returned to the requester, in this case our SP.
        'assertionConsumerService'  => array(
            // URL Location where the <Response> from the IdP will be returned
            'url'     => '',
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-POST binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ),
        // If you need to specify requested attributes, set a
        // attributeConsumingService. nameFormat, attributeValue and
        // friendlyName can be omitted. Otherwise remove this section.
        "attributeConsumingService" => array(
            "serviceName"         => "SP test",
            "serviceDescription"  => "Test Service",
            "requestedAttributes" => array(
                array(
                    "name"           => "",
                    "isRequired"     => false,
                    "nameFormat"     => "",
                    "friendlyName"   => "",
                    "attributeValue" => "",
                ),
            ),
        ),
        // Specifies info about where and how the <Logout Response> message MUST be
        // returned to the requester, in this case our SP.
        'singleLogoutService'       => array(
            // URL Location where the <Response> from the IdP will be returned
            'url'     => '',
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-Redirect binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        // Specifies constraints on the name identifier to be used to
        // represent the requested subject.
        // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported
        'NameIDFormat'              => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',

        // Usually x509cert and privateKey of the SP are provided by files placed at
        // the certs folder. But we can also provide them with the following parameters
        'x509cert'                  => '',
        'privateKey'                => '',

        /*
         * Key rollover
         * If you plan to update the SP x509cert and privateKey
         * you can define here the new x509cert and it will be
         * published on the SP metadata so Identity Providers can
         * read them and get ready for rollover.
         */
        // 'x509certNew' => '',
    ),

    // Identity Provider Data that we want connect with our SP
    'idp'     => array(
        // Identifier of the IdP entity  (must be a URI)
        'entityId'            => '',
        // SSO endpoint info of the IdP. (Authentication Request protocol)
        'singleSignOnService' => array(
            // URL Target of the IdP where the SP will send the Authentication Request Message
            'url'     => '',
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-Redirect binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        // SLO endpoint info of the IdP.
        'singleLogoutService' => array(
            // URL Location of the IdP where the SP will send the SLO Request
            'url'         => '',
            // URL location of the IdP where the SP SLO Response will be sent (ResponseLocation)
            // if not set, url for the SLO Request will be used
            'responseUrl' => '',
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-Redirect binding only
            'binding'     => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        // Public x509 certificate of the IdP
        'x509cert'            => '',
        /*
         *  Instead of use the whole x509cert you can use a fingerprint in
         *  order to validate the SAMLResponse, but we don't recommend to use
         *  that method on production since is exploitable by a collision
         *  attack.
         *  (openssl x509 -noout -fingerprint -in "idp.crt" to generate it,
         *   or add for example the -sha256 , -sha384 or -sha512 parameter)
         *
         *  If a fingerprint is provided, then the certFingerprintAlgorithm is required in order to
         *  let the toolkit know which Algorithm was used. Possible values: sha1, sha256, sha384 or sha512
         *  'sha1' is the default value.
         */
        // 'certFingerprint' => '',
        // 'certFingerprintAlgorithm' => 'sha1',

        /* In some scenarios the IdP uses different certificates for
         * signing/encryption, or is under key rollover phase and more
         * than one certificate is published on IdP metadata.
         * In order to handle that the toolkit offers that parameter.
         * (when used, 'x509cert' and 'certFingerprint' values are
         * ignored).
         */
        // 'x509certMulti' => array(
        //      'signing' => array(
        //          0 => '<cert1-string>',
        //      ),
        //      'encryption' => array(
        //          0 => '<cert2-string>',
        //      )
        // ),
    ),
);

//perf
$config['azuread'] = array(
    'autologin' => false,
    'debug' => true,
    'showloginbox' => true,
    'sp'    => array(
        'entityId'                 => $path . 'home/sso_metadata',
        'assertionConsumerService' => array(
            'url' => $path . 'home/sso_login?acs',
        ),
        'singleLogoutService'      => array(
            'url' => $path . 'home/sso_login?sls',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
    ),
    'idp'   => array(
        'entityId'            => 'https://sts.windows.net/710de1d3-2901-4647-89e7-3b01f1c2806d/',
        'singleSignOnService' => array(
            'url' => 'https://login.microsoftonline.com/710de1d3-2901-4647-89e7-3b01f1c2806d/saml2',
        ),
        'singleLogoutService' => array(
            'url' => 'https://login.microsoftonline.com/710de1d3-2901-4647-89e7-3b01f1c2806d/saml2',
        ),
        'x509cert'            => '-----BEGIN CERTIFICATE-----
MIIDBTCCAe2gAwIBAgIQV68hSN9DrrlCaA3NJ0bnfDANBgkqhkiG9w0BAQsFADAtMSswKQYDVQQDEyJhY2NvdW50cy5hY2Nlc3Njb250cm9sLndpbmRvd3MubmV0MB4XDTE4MTExMTAwMDAwMFoXDTIwMTExMTAwMDAwMFowLTErMCkGA1UEAxMiYWNjb3VudHMuYWNjZXNzY29udHJvbC53aW5kb3dzLm5ldDCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBALvfCr6FB37Ns9mCcn5Cc2hhWDOfHg9HqR3xE08DQ5egC/3E3zpJXMTOI6y1r1aqqdrB2h9IBaWD8qLzfv2pJhP+H5HNFcP8BjOYwz/o5zidbwb2xaBe7gQMuK95Z9nstT6BlIaZF3Q2sISH3QG3O1i7cqKRzVkFyN9+q14sI73Iy/HR4YnrwzpLbALIpQAz+cCU9Jck4nzjT2Tqvl1gsPRbVwEK+w54jgubg7lGi9JjNVCQoYgqw5hTgH+gjXbtksC4p12GrqjPTkRJSmBAoaBH4udX3LJpbJ+JrTT5MbLb0eziYiQab5OxS3omgbTJ7Ducd9Az4K4QGoK1Z9yGikUCAwEAAaMhMB8wHQYDVR0OBBYEFGWLmYFSm5Exg9VcAGSg5sFE1mXgMA0GCSqGSIb3DQEBCwUAA4IBAQB0yTGzyhx+Hz2vwBSo5xCkiIom6h7b946KKiWvgBLeOvAuxOsB15N+bbf51sUfUJ6jBaa1uJjJf27dxwH0oUe2fcmEN76QSrhULYe+k5yyJ7vtCnd6sHEfn9W6iRozv0cb48tESOTlFuwbYDVW+YZxzM9EQHC32CjugURzuN9/rf6nJ9etSeckRMO8QPqyIi4e5sGSDYExxNs7J4prhIbtYT4NRiqc4nWzA/p5wSYOUgAZMSTLD/beSI81UN1Ao9VBBJu3v83d62WL3zHSbpUwtG/utNhSi/n/7Q94claEWJVhBx6LiA1hrU6YZkjRGqBOrWIZkSkh75xW6Xujocy4
-----END CERTIFICATE-----
',
    ),
);

//jumpcloud
$config['localhost']  = array(
    'autologin' => false,
    'debug' => true,
    'showloginbox' => true,
    'sp'    => array(
        'entityId'                 => $path . 'ssologin/metadata.php',
        'assertionConsumerService' => array(
            'url' => $path . 'ssologin/index.php?acs',
        ),
        'singleLogoutService'      => array(
            'url' => $path . 'ssologin/index.php?sls',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
        'x509cert'            => '-----BEGIN CERTIFICATE-----
        MIICtDCCAh2gAwIBAgIBADANBgkqhkiG9w0BAQ0FADB3MQswCQYDVQQGEwJpbjEX
        MBUGA1UECAwOTWFkaHlhIFByYWRlc2gxFTATBgNVBAoMDGNvbXBwb3J0LmNvbTER
        MA8GA1UEAwwIY29tcHBvcnQxDzANBgNVBAcMBkJob3BhbDEUMBIGA1UECwwLZGV2
        ZWxvcG1lbnQwHhcNMjAwMjEzMDcwNjQ4WhcNMjQwMzIzMDcwNjQ4WjB3MQswCQYD
        VQQGEwJpbjEXMBUGA1UECAwOTWFkaHlhIFByYWRlc2gxFTATBgNVBAoMDGNvbXBw
        b3J0LmNvbTERMA8GA1UEAwwIY29tcHBvcnQxDzANBgNVBAcMBkJob3BhbDEUMBIG
        A1UECwwLZGV2ZWxvcG1lbnQwgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBALcx
        Ur85+yh6XtLIJrkVTKjwV2tAmyKnFlVhRPtKQSCIm5w4ax3piZVC16CYVA+9Igir
        vqs3JUjJ6G3ic2D3zm8o67lfMHwT2+H/Yu0fNIVWzpxHsn7nGplwcSpMJu/wnja6
        KInGsnwhkbanoQyyPGw5MoQxlEg/g4GOgZGUvwp9AgMBAAGjUDBOMB0GA1UdDgQW
        BBQYCBitBxEq05Bq1z51hTGLtyZihTAfBgNVHSMEGDAWgBQYCBitBxEq05Bq1z51
        hTGLtyZihTAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBDQUAA4GBADvFRhsTehzA
        rmU0xTMgCN/X5GueV9ODJ1gnkmZpzuac6PFlZ5gDndJx0txEnJLzs486ikW62n9o
        kOXdTHWW1JR3mluylD6Mz7rmnfggtJCrugTJJDL0xlsS3uK95HwCw8oHN7c64cKU
        SsfoN0ELPVRMfk7Vofq295m580grufLi
        -----END CERTIFICATE-----',
        'privateKey'                => '-----BEGIN PRIVATE KEY-----
        MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBALcxUr85+yh6XtLI
        JrkVTKjwV2tAmyKnFlVhRPtKQSCIm5w4ax3piZVC16CYVA+9Igirvqs3JUjJ6G3i
        c2D3zm8o67lfMHwT2+H/Yu0fNIVWzpxHsn7nGplwcSpMJu/wnja6KInGsnwhkban
        oQyyPGw5MoQxlEg/g4GOgZGUvwp9AgMBAAECgYBKjWEef4suAvb6EwhnRDrJed4p
        wMYhyRv2rTo0hhiRE+c4IWG+b59VRjmYmsWDDjZ+jt5usWeUAs97gK/x44d31hY2
        S6N5bBc5xYqS877pOU8Un0pWmBd5mkJ1HNbO42HQJnkJGV9vbJrMj+PojiAm9x+m
        LNXfFmlZtXOGaZ8aYQJBAPOBHD12UZLA82VN/R60FFyiSg9BzFcVop3DiEcbi90h
        I4GfMovSxZ2UMQYiKQgfuUhxAYNPSniORg6+QQfxvxUCQQDAl+e5ADcBcwcgzVtx
        nuNK5KGOv/F+0/KmcrRZkbHmASKJhr5haA+M4sxf1AXwsTb7ycgNubzmCweBmBC8
        +LfJAkB9T033GzJzcTRQR8ggys9HtISkQVok3o9m3L7+yOA7Fdit1f0vE3J62043
        N9EhyyGQdAcxSdarH5xR7fqNWgzZAkBjFMNN1eJ2iGr+YSfOSGO+v+itu+nNydRn
        9VL7UY0oOyU9g2imTBbT8EoccsOrlEApQSH+jbO01a/C6CyUS5ChAkAWdpLiofi1
        G0REj5mvbpbZXgiaJael4Ct3JaUqSlogAt8eCH9dap2VNYIpPMYJ0bplEKnQOprk
        stJ+358XUp0c
        -----END PRIVATE KEY-----',

        "attributeConsumingService" => array(
            "serviceName" => "Compport",
            "serviceDescription" => "Compport",
            "requestedAttributes" => array(
                array(
                    "name" => "email",
                    "isRequired" => false,
                    "nameFormat" => "urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified",
                    "friendlyName" => "Official Email",
                    "attributeValue" => array()
                ),
                array(
                    "name" => "employee_code",
                    "isRequired" => false,
                    "nameFormat" => "urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified",
                    "friendlyName" => "Employee Code",
                    "attributeValue" => array()
                )
            )
        ),
    ),
    'idp'   => array(
        'entityId'            => 'http://localhost/compport/alpha',
        'singleSignOnService' => array(
            'url' => 'https://sso.jumpcloud.com/saml2/perflocalsaml2',
        ),
        'singleLogoutService' => array(
            'url' => 'https://sso.jumpcloud.com/saml2/perflocalsaml2',
        ),
        'x509cert'            => '-----BEGIN CERTIFICATE-----
        MIIFfzCCA2egAwIBAgIVAOz9xplheQkH0LPR56bAxBVuUqIbMA0GCSqGSIb3DQEBCwUAMHcxCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDTzEQMA4GA1UEBxMHQm91bGRlcjESMBAGA1UEChMJSnVtcENsb3VkMRkwFwYDVQQLExBKdW1wQ2xvdWRTQU1MSWRQMRowGAYDVQQDExFKdW1wQ2xvdWRTQU1MVXNlcjAeFw0yMDAxMDgxMzI1NTRaFw0yNTAxMDgxMzI1NTRaMHcxCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDTzEQMA4GA1UEBxMHQm91bGRlcjESMBAGA1UEChMJSnVtcENsb3VkMRkwFwYDVQQLExBKdW1wQ2xvdWRTQU1MSWRQMRowGAYDVQQDExFKdW1wQ2xvdWRTQU1MVXNlcjCCAiIwDQYJKoZIhvcNAQEBBQADggIPADCCAgoCggIBAJ7CqE1pZ+j6w8eFImSrZyC2cBP2RMfF6y8TjspHdEgQPSRzN3w4/Xa/2ZR/T0RJ+osEPcSfzYC65m0iA7WWqNDyK0h9wDvTlRfSXp7Hs2hTYuqLCsGMCiwcw7TsYxqV+0pOXAYeCRJZEyWyxBBVsjDDW/Jl3Y5aBCkD1T/st+3P2HsvTZWGcu/WV1xuR8TQY1QRi2BVGIPfTu1GbqkWg8wglzDrMpURLLrzBknfrzbad7JhYM5InYE4Ehgftrg4P2Gsyip2YW8rM2g4z8Fc++WfYJAwsA+A1h9L8/gQgWCjZu4Y6IaLBb/9ye8w/6HyJKOoSy/KrlsGkfsQdKkovj8ZD7xvR9HjeWpoi5vfh3PeCoiyGwds3HmQCEd2cJMKhsZjTKoPZnYMrEkpoM/BKKo7QGAio7DkDf9Z1RhzbTU0pgywlc7dX+o7WTEgYubDEadjTBn0lIzRk474U6okfUT+fJ5/+aRN8m0Xo6dI7vfczFqU26LAva//1m2si5TfdUXzZxz6Mhs/j7aULkxqeA2EGdhsEaZqRTQeOktN2c+AbkWhQwkAyxKc1e9VrvHQJclm1/LELPDIeiqlzDLesXeE2MksHGLLugIxzcYBJY+asrYG+BXpiEGdwRvHTlIb2idmxdWAaaQUBdzYhpsQbSmjqlL4N3IqdE2PNMAC1UqnAgMBAAGjAjAAMA0GCSqGSIb3DQEBCwUAA4ICAQBFP2Goh5zyRONNpE4DEt3Vwjwk19e55GG+6iTkWdspIeioNwRNTWb1xOuXpDjYuUQHCXxWi+j62Ah/nNcaLEHgHYtvtlJ/nljMOVd6iqFxtUngdNyigaLsDDgQ+ipzASz0w5v2DGXlHl+fLCpOannLm70Ug5HWUX2bbh+zyXYY8zou3eX26cwqCAzfoMqjPm/dLoZzvU3ektT9kyB/tPQ1LbtmHRqFkiu44VzjGnul1a7/bybyA9Z51qeGqUFyXOrpsje8OKdfv6es6pG0grr0V4nbAkdTLR9o9WKaayEykXw2jAirrMKScHohL99eHYjPrdaru9sK9kjlg99ELOXAoiyYsKFTVASF6fEb4jHKeqqbm2iYw6oBcjJztX0D92yYuj95tIE4RL/t1HA/9m6FRBlAmst1y2k5cps7yvhv2/nk6QHdy4xk1PCft7eDYKngZ5RMvx83lQ0LlyDfnzqNdCeXdyMoaQRuQ1T3pFxmdvcWaD9ZPZFMreYMHfgR5F5bIE6FWlE3yvdtdwut4HYHzhO1y/OdKMpm/X7BsTVNVNVo3dId+J/Yy6RHhYhJv/KaCO+cTA7WwU28iO08ROcQvbRdMLAsBuMjQV6an4jie0Ax0caAVwSpUUn7JE7aFZfOJ3TA1shQ/NAOVO8giQlschMibgKO1zq9nnDZ3gqoiw==
-----END CERTIFICATE-----
',
        'mapping_attributes' => array(
            'email' => 'email',
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'username' => 'username',
            //    'email' => 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'
        ),
    ),
);



//okta
$config['localhost1']  = array(
    'autologin' => false,
    'debug' => true,
    'showloginbox' => true,
    'sp'    => array(
        'entityId'                 => $path . 'ssologin/metadata.php',
        'assertionConsumerService' => array(
            'url' => $path . 'ssologin/index.php?acs',
        ),
        'singleLogoutService'      => array(
            'url' => $path . 'ssologin/index.php?sls',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
    ),
    'idp'   => array(
        'entityId'            => 'http://www.okta.com/exk2u6uybqnA3OCh3357',
        'singleSignOnService' => array(
            'url' => 'https://dev-960097.okta.com/app/dentistsatishcomdev960097_local_2/exk2u6uybqnA3OCh3357/sso/saml',
        ),
        'singleLogoutService' => array(
            'url' => 'https://dev-960097.okta.com/app/dentistsatishcomdev960097_local_2/exk2u6uybqnA3OCh3357/slo/saml',
        ),
        'x509cert'            => '-----BEGIN CERTIFICATE-----
        MIIDpDCCAoygAwIBAgIGAW9h5mObMA0GCSqGSIb3DQEBCwUAMIGSMQswCQYDVQQGEwJVUzETMBEG
        A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
        MBIGA1UECwwLU1NPUHJvdmlkZXIxEzARBgNVBAMMCmRldi05NjAwOTcxHDAaBgkqhkiG9w0BCQEW
        DWluZm9Ab2t0YS5jb20wHhcNMjAwMTAxMTYxNzA2WhcNMzAwMTAxMTYxODA2WjCBkjELMAkGA1UE
        BhMCVVMxEzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNV
        BAoMBE9rdGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMRMwEQYDVQQDDApkZXYtOTYwMDk3MRwwGgYJ
        KoZIhvcNAQkBFg1pbmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA
        uJXv2dDnjr1Z+gS82Ju50QBG0keRQCO0UswINg9Oyx7zAnR5Uat7lHncgS3EBbY6xyM8mRAhLUfs
        bHEL+H/ygQh8UHzPfgHixpigoxmehPQ9XjzlXzdYX3H1VJyykkiVYSJzEl9Kv71eVfEXTK4yjQgx
        DU1HBn9NgEAEA0OKRzqoNuGtEcFhryH9y9Wcc/aatb+xDSYtLnGZqZ/iY2jF+xwTIhg8lFpU0XK7
        zxBH1QTts9VeTKOJALsrWGXrj7vArvE7/rXLHEihJEsdLjsj7JjB9+lUc60P9Q0hZojor61cUGNl
        vhTN4BRgium5Ltv5u1qgWx3mGOL62uwktwUh9QIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQARtoBJ
        qoDyTZSJ4zg6M3qCXEJuRDKdMpvAjgXI69Q9hgvDsyk5ykfqva7c8YBH1BZa7sy4mwDq6tpFutUm
        oJLQEM0PVDF1P5FlFjaxvceoeti3i+LlHZlooUED0ZSfQhn/G4VYMaRHvSH4R7v61UV6jYW4n3Zr
        unVepF5/iVazyANE/1rNd7TLJxSxP2rZUoMjHgwDHL1EdszDRSjQ2f14zeRH4nKdPSMdSXhj43vi
        Ki2LIRqDN2wquQFtxHqHUFSZedDVYI1FX0gC9ill+ZCUf44aAt4X63Fw6m5bj9trEnBNCG049rrw
        PZjaXnsLDP261veidaIpl63Gzm4lbn8x
        -----END CERTIFICATE-----',
        /*'mapping_attributes' => array(
         //   'email' => 'email',
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'username' => 'username',
            'email' => 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'
        ),*/
    ),
);

//onelogin
$config['localhost']  = array(
    'autologin' => false,
    'debug' => true,
    'showloginbox' => true,
    'sp'    => array(
        'entityId'                 => $path . 'ssologin/metadata.php',
        'assertionConsumerService' => array(
            'url' => $path . 'ssologin/index.php?acs',
        ),
        'singleLogoutService'      => array(
            'url' => $path . 'ssologin/index.php?sls',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
        "attributeConsumingService" => array(
            "serviceName" => "Compport",
            "serviceDescription" => "Compport",
            "requestedAttributes" => array(
                array(
                    "name" => "email",
                    "isRequired" => false,
                    "nameFormat" => "urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified",
                    "friendlyName" => "Official Email",
                    "attributeValue" => array()
                ),
                array(
                    "name" => "employee_code",
                    "isRequired" => false,
                    "nameFormat" => "urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified",
                    "friendlyName" => "Employee Code",
                    "attributeValue" => array()
                )
            )
        ),
    ),
    'idp'   => array(
        //'reverseLogout'    =>    true,
        'entityId'            => 'https://app.onelogin.com/saml/metadata/9d44e57e-913c-4c3b-8b2a-d9b12dd751dc',
        'singleSignOnService' => array(
            'url' => 'https://compp-dev.onelogin.com/trust/saml2/http-post/sso/9d44e57e-913c-4c3b-8b2a-d9b12dd751dc',
        ),
        'singleLogoutService' => array(
            'url' => 'https://compp-dev.onelogin.com/trust/saml2/http-redirect/slo/1031980',
        ),
        'x509cert'            => '-----BEGIN CERTIFICATE-----
        MIID1TCCAr2gAwIBAgIUP9iKEVumvdXoDP7zHK9+2I+xw3UwDQYJKoZIhvcNAQEF
        BQAwQzEOMAwGA1UECgwFY29tcHAxFTATBgNVBAsMDE9uZUxvZ2luIElkUDEaMBgG
        A1UEAwwRT25lTG9naW4gQWNjb3VudCAwHhcNMTkxMTIwMDY0ODQyWhcNMjQxMTIw
        MDY0ODQyWjBDMQ4wDAYDVQQKDAVjb21wcDEVMBMGA1UECwwMT25lTG9naW4gSWRQ
        MRowGAYDVQQDDBFPbmVMb2dpbiBBY2NvdW50IDCCASIwDQYJKoZIhvcNAQEBBQAD
        ggEPADCCAQoCggEBAJopIEsl0J8F0N8OL07PWYITgX+T7Q6m0TnkgPBkUJtqTwpj
        BJRg+pm/HidW7yuXSyOwHPGLnig/gaKWSTbshCQ4RQ+9kLujFBTSydVxqiN9hcrV
        /3vlwtiXe18ydFAyYX18tjvHwSkemQSuOA6kKzUwr3eAavP+E+3IC6CWbN5sOaKW
        xsRhc90QOzBzCZZQGKZ2OmI5eK2QomwgRdt7Ko2b1XMB9HjdnhnaAAp8LPmikEU5
        8g5rUxEWEBh2+6xL5B/gEc/Fz8mWHCmFNqlBGbrRZbTybVzl6WvCw4wf8WKcXKta
        djC5kyt3hpV4PKX2ZUNcNu9AC8QsZiq72t+N0b0CAwEAAaOBwDCBvTAMBgNVHRMB
        Af8EAjAAMB0GA1UdDgQWBBS36+9OjnXe3eYrdGNTAXRULtlN8zB+BgNVHSMEdzB1
        gBS36+9OjnXe3eYrdGNTAXRULtlN86FHpEUwQzEOMAwGA1UECgwFY29tcHAxFTAT
        BgNVBAsMDE9uZUxvZ2luIElkUDEaMBgGA1UEAwwRT25lTG9naW4gQWNjb3VudCCC
        FD/YihFbpr3V6Az+8xyvftiPscN1MA4GA1UdDwEB/wQEAwIHgDANBgkqhkiG9w0B
        AQUFAAOCAQEAFG3sdI+7gvULOczU2+aGK3iwRDWHo/6bzMvKbG0Fq9whjQqZ933O
        dsXnYR+x3iD3+JjwjbRmvpueyVrEfejamjV6zTyUFtfxP6bb1fpF2GcY4gSIRFfN
        yi4DJOiJahq6U/XsVwLYz7vQPnFCobYe0ZcDWNNmgBcNxtXEnGtF9JJHkRRhrGDD
        ollMaKhpGH9K+Hp6FiGq+4FmsvtBLSedm3qh1V6HEQB7I8Eb5vrV79J+5eCzHSlf
        IR4udkzN9bzixyj0GYXQSdqVXQdnc1xUTNGakVqot3+aRfkg/DuR1uMq2xYqqvVJ
        G8uN74UnJAJCQq4SbUPvv2qDPaEAuYQtLw==
        -----END CERTIFICATE-----',
        'mapping_attributes' => array(
            //   'email' => 'email',
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'username' => 'username',
            'email' => 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'
        ),
    ),
);

//okta
$config['uat.compport.com']  = array(
    'autologin' => false,
    'debug' => true,
    'showloginbox' => true,
    'sp'    => array(
        'entityId'                 => $path . 'ssologin/metadata.php',
        'assertionConsumerService' => array(
            'url' => $path . 'ssologin/index.php?acs',
        ),
        'singleLogoutService'      => array(
            'url' => $path . 'ssologin/index.php?sls',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
    ),
    'idp'   => array(
        'entityId'            => 'http://www.okta.com/exk2dcciipw6EEWRA357',
        'singleSignOnService' => array(
            'url' => 'https://dev-960097.okta.com/app/dentistsatishcomdev960097_local_1/exk2dcciipw6EEWRA357/sso/saml',
        ),
        'singleLogoutService' => array(
            'url' => 'https://dev-960097.okta.com/app/dentistsatishcomdev960097_local_1/exk2dcciipw6EEWRA357/sso/saml',
        ),
        'x509cert'            => '-----BEGIN CERTIFICATE-----
        MIIDpDCCAoygAwIBAgIGAW9h5mObMA0GCSqGSIb3DQEBCwUAMIGSMQswCQYDVQQGEwJVUzETMBEG
        A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
        MBIGA1UECwwLU1NPUHJvdmlkZXIxEzARBgNVBAMMCmRldi05NjAwOTcxHDAaBgkqhkiG9w0BCQEW
        DWluZm9Ab2t0YS5jb20wHhcNMjAwMTAxMTYxNzA2WhcNMzAwMTAxMTYxODA2WjCBkjELMAkGA1UE
        BhMCVVMxEzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNV
        BAoMBE9rdGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMRMwEQYDVQQDDApkZXYtOTYwMDk3MRwwGgYJ
        KoZIhvcNAQkBFg1pbmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA
        uJXv2dDnjr1Z+gS82Ju50QBG0keRQCO0UswINg9Oyx7zAnR5Uat7lHncgS3EBbY6xyM8mRAhLUfs
        bHEL+H/ygQh8UHzPfgHixpigoxmehPQ9XjzlXzdYX3H1VJyykkiVYSJzEl9Kv71eVfEXTK4yjQgx
        DU1HBn9NgEAEA0OKRzqoNuGtEcFhryH9y9Wcc/aatb+xDSYtLnGZqZ/iY2jF+xwTIhg8lFpU0XK7
        zxBH1QTts9VeTKOJALsrWGXrj7vArvE7/rXLHEihJEsdLjsj7JjB9+lUc60P9Q0hZojor61cUGNl
        vhTN4BRgium5Ltv5u1qgWx3mGOL62uwktwUh9QIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQARtoBJ
        qoDyTZSJ4zg6M3qCXEJuRDKdMpvAjgXI69Q9hgvDsyk5ykfqva7c8YBH1BZa7sy4mwDq6tpFutUm
        oJLQEM0PVDF1P5FlFjaxvceoeti3i+LlHZlooUED0ZSfQhn/G4VYMaRHvSH4R7v61UV6jYW4n3Zr
        unVepF5/iVazyANE/1rNd7TLJxSxP2rZUoMjHgwDHL1EdszDRSjQ2f14zeRH4nKdPSMdSXhj43vi
        Ki2LIRqDN2wquQFtxHqHUFSZedDVYI1FX0gC9ill+ZCUf44aAt4X63Fw6m5bj9trEnBNCG049rrw
        PZjaXnsLDP261veidaIpl63Gzm4lbn8x
        -----END CERTIFICATE-----',
        'mapping_attributes' => array(
            //   'email' => 'email',
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'username' => 'username',
            'email' => 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'
        ),
    ),
);


//indigo
$config['indigo.compport.com']  = array(
    'strict' => false,
    'autologin' => false,
    'debug' => false,
    'baseurl' => 'https://indigo.compport.com/ssologin',
    'showloginbox' => true,
    'sp'    => array(
        'entityId'                 => $path . 'ssologin/metadata.php',
        'assertionConsumerService' => array(
            'url' => $path . 'ssologin/index.php?acs',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ),
        'singleLogoutService'      => array(
            'url' => $path . 'ssologin/index.php?sls',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
        'x509cert'            => '-----BEGIN CERTIFICATE-----
        MIICtDCCAh2gAwIBAgIBADANBgkqhkiG9w0BAQ0FADB3MQswCQYDVQQGEwJpbjEX
        MBUGA1UECAwOTWFkaHlhIFByYWRlc2gxFTATBgNVBAoMDGNvbXBwb3J0LmNvbTER
        MA8GA1UEAwwIY29tcHBvcnQxDzANBgNVBAcMBkJob3BhbDEUMBIGA1UECwwLZGV2
        ZWxvcG1lbnQwHhcNMjAwMjEzMDcwNjQ4WhcNMjQwMzIzMDcwNjQ4WjB3MQswCQYD
        VQQGEwJpbjEXMBUGA1UECAwOTWFkaHlhIFByYWRlc2gxFTATBgNVBAoMDGNvbXBw
        b3J0LmNvbTERMA8GA1UEAwwIY29tcHBvcnQxDzANBgNVBAcMBkJob3BhbDEUMBIG
        A1UECwwLZGV2ZWxvcG1lbnQwgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBALcx
        Ur85+yh6XtLIJrkVTKjwV2tAmyKnFlVhRPtKQSCIm5w4ax3piZVC16CYVA+9Igir
        vqs3JUjJ6G3ic2D3zm8o67lfMHwT2+H/Yu0fNIVWzpxHsn7nGplwcSpMJu/wnja6
        KInGsnwhkbanoQyyPGw5MoQxlEg/g4GOgZGUvwp9AgMBAAGjUDBOMB0GA1UdDgQW
        BBQYCBitBxEq05Bq1z51hTGLtyZihTAfBgNVHSMEGDAWgBQYCBitBxEq05Bq1z51
        hTGLtyZihTAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBDQUAA4GBADvFRhsTehzA
        rmU0xTMgCN/X5GueV9ODJ1gnkmZpzuac6PFlZ5gDndJx0txEnJLzs486ikW62n9o
        kOXdTHWW1JR3mluylD6Mz7rmnfggtJCrugTJJDL0xlsS3uK95HwCw8oHN7c64cKU
        SsfoN0ELPVRMfk7Vofq295m580grufLi
        -----END CERTIFICATE-----',
        'privateKey'                => '-----BEGIN PRIVATE KEY-----
        MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBALcxUr85+yh6XtLI
        JrkVTKjwV2tAmyKnFlVhRPtKQSCIm5w4ax3piZVC16CYVA+9Igirvqs3JUjJ6G3i
        c2D3zm8o67lfMHwT2+H/Yu0fNIVWzpxHsn7nGplwcSpMJu/wnja6KInGsnwhkban
        oQyyPGw5MoQxlEg/g4GOgZGUvwp9AgMBAAECgYBKjWEef4suAvb6EwhnRDrJed4p
        wMYhyRv2rTo0hhiRE+c4IWG+b59VRjmYmsWDDjZ+jt5usWeUAs97gK/x44d31hY2
        S6N5bBc5xYqS877pOU8Un0pWmBd5mkJ1HNbO42HQJnkJGV9vbJrMj+PojiAm9x+m
        LNXfFmlZtXOGaZ8aYQJBAPOBHD12UZLA82VN/R60FFyiSg9BzFcVop3DiEcbi90h
        I4GfMovSxZ2UMQYiKQgfuUhxAYNPSniORg6+QQfxvxUCQQDAl+e5ADcBcwcgzVtx
        nuNK5KGOv/F+0/KmcrRZkbHmASKJhr5haA+M4sxf1AXwsTb7ycgNubzmCweBmBC8
        +LfJAkB9T033GzJzcTRQR8ggys9HtISkQVok3o9m3L7+yOA7Fdit1f0vE3J62043
        N9EhyyGQdAcxSdarH5xR7fqNWgzZAkBjFMNN1eJ2iGr+YSfOSGO+v+itu+nNydRn
        9VL7UY0oOyU9g2imTBbT8EoccsOrlEApQSH+jbO01a/C6CyUS5ChAkAWdpLiofi1
        G0REj5mvbpbZXgiaJael4Ct3JaUqSlogAt8eCH9dap2VNYIpPMYJ0bplEKnQOprk
        stJ+358XUp0c
        -----END PRIVATE KEY-----',
        "attributeConsumingService" => array(
            "serviceName" => "Compport",
            "serviceDescription" => "Compport",
            "requestedAttributes" => array(
                array(
                    "name" => "email",
                    "isRequired" => false,
                    "nameFormat" => "urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified",
                    "friendlyName" => "Official Email",
                    "attributeValue" => array()
                ),
                array(
                    "name" => "employee_code",
                    "isRequired" => false,
                    "nameFormat" => "urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified",
                    "friendlyName" => "Employee Code",
                    "attributeValue" => array()
                )
            )
        ),

    ),
    'idp'   => array(
        'entityId'            => 'http://testlogin.goindigo.in/adfs/services/trust',
        //'reverseLogout'    => 'https://testlogin.goindigo.in/adfs/ls/?wa=wsignout1.0',
        'reverseLogout'    =>    true,
        'singleSignOnService' => array(
            'url' => 'https://testlogin.goindigo.in/adfs/ls/',
        ),
        'singleLogoutService' => array(
            'url' => 'https://testlogin.goindigo.in/adfs/ls/?wa=wsignout1.0',
            'binding'     => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        'x509cert'            => '-----BEGIN CERTIFICATE-----
        MIIC5jCCAc6gAwIBAgIQXTn0FrkcLL9CPemlPA3lrjANBgkqhkiG9w0BAQsFADAvMS0wKwYDVQQDEyRBREZTIFNpZ25pbmcgLSB0ZXN0bG9naW4uZ29pbmRpZ28uaW4wHhcNMTcxMDE2MTUxOTIxWhcNMjAxMDE1MTUxOTIxWjAvMS0wKwYDVQQDEyRBREZTIFNpZ25pbmcgLSB0ZXN0bG9naW4uZ29pbmRpZ28uaW4wggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDa2Rr5AWQmqtcrPlmA9Qvv5LWT/otelD39FZOcNTb/YoJbK8KHN3Muv/zzN+bJ2Ab5NR3lcAoLB124PZ66LvChc64hViZhAm56CwbO5/ApEzOPmjcAyG7x/+ikzoKGpCHWfC24LpYwHnvuUvmV2xDdbUbktLSl2wqE5iYQX1FZGvDSWMf7ApVYNx3jR24xxUN0w/TOFgm+3TNZP9deYKNmYXw66b/5wWXuK1T0+528SsIB6B4q3MCg0BYX8aMFC+G87ciI4wuG/Z2x0LPPxDXTL0CIMTjQqEfscce0k5gDVTGkT2/HIAhFjkZOCqCQMAnQk9ZrORff5o0XqhF4S8CnAgMBAAEwDQYJKoZIhvcNAQELBQADggEBAA64MFaTqQEnRXBJvG0AUWv2ctB81zyYZ9Cs9/wwYo5+msYWNuy4wqoU9yeObxW9g8BrQiC74e97G49M3mR8HKe8qOfkdfQta96Y8vQzQL4TEvHNKhQpUVVo06NeGssb338AKpLxt5D9uMq+tnhD5pmnDFKE1ZiEyuU3XiPryyYOSMfQc10akOOceTROd5t0Tp042zD9kXsmm/YuR5okm4KYlqSyRGXR3HKBgcyQ/mkZxjeDIqUH+wWBA72ra2Tuwi8L7r59KJuXDXdHwTzhd14mk1mjMrVu4CSDRSVFFmrOqgzAIHE7M+yKnJn0PjtbtLHah6fhtPAHLhmzgBe0/jE=
        -----END CERTIFICATE-----',
        'mapping_attributes' => array(
            //  'email' => 'email',
            //  'firstname' => 'firstname',
            'lastname' => 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname',
            'name' => 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name',
            'email' => 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'
        ),
    ),
);


//indigo
$config['uat.compport.com']  = array(
    'strict' => false,
    'autologin' => false,
    'debug' => true,
    'baseurl' => 'https://uat.compport.com/ssologin',
    'showloginbox' => true,
    'sp'    => array(
        'entityId'                 => $path . 'ssologin/metadata.php',
        'assertionConsumerService' => array(
            'url' => $path . 'ssologin/index.php?acs',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ),
        'singleLogoutService'      => array(
            'url' => $path . 'ssologin/index.php?sls',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
        'x509cert'            => '-----BEGIN CERTIFICATE-----
        MIICtDCCAh2gAwIBAgIBADANBgkqhkiG9w0BAQ0FADB3MQswCQYDVQQGEwJpbjEX
        MBUGA1UECAwOTWFkaHlhIFByYWRlc2gxFTATBgNVBAoMDGNvbXBwb3J0LmNvbTER
        MA8GA1UEAwwIY29tcHBvcnQxDzANBgNVBAcMBkJob3BhbDEUMBIGA1UECwwLZGV2
        ZWxvcG1lbnQwHhcNMjAwMjEzMDcwNjQ4WhcNMjQwMzIzMDcwNjQ4WjB3MQswCQYD
        VQQGEwJpbjEXMBUGA1UECAwOTWFkaHlhIFByYWRlc2gxFTATBgNVBAoMDGNvbXBw
        b3J0LmNvbTERMA8GA1UEAwwIY29tcHBvcnQxDzANBgNVBAcMBkJob3BhbDEUMBIG
        A1UECwwLZGV2ZWxvcG1lbnQwgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBALcx
        Ur85+yh6XtLIJrkVTKjwV2tAmyKnFlVhRPtKQSCIm5w4ax3piZVC16CYVA+9Igir
        vqs3JUjJ6G3ic2D3zm8o67lfMHwT2+H/Yu0fNIVWzpxHsn7nGplwcSpMJu/wnja6
        KInGsnwhkbanoQyyPGw5MoQxlEg/g4GOgZGUvwp9AgMBAAGjUDBOMB0GA1UdDgQW
        BBQYCBitBxEq05Bq1z51hTGLtyZihTAfBgNVHSMEGDAWgBQYCBitBxEq05Bq1z51
        hTGLtyZihTAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBDQUAA4GBADvFRhsTehzA
        rmU0xTMgCN/X5GueV9ODJ1gnkmZpzuac6PFlZ5gDndJx0txEnJLzs486ikW62n9o
        kOXdTHWW1JR3mluylD6Mz7rmnfggtJCrugTJJDL0xlsS3uK95HwCw8oHN7c64cKU
        SsfoN0ELPVRMfk7Vofq295m580grufLi
        -----END CERTIFICATE-----',
        'privateKey'                => '-----BEGIN PRIVATE KEY-----
        MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBALcxUr85+yh6XtLI
        JrkVTKjwV2tAmyKnFlVhRPtKQSCIm5w4ax3piZVC16CYVA+9Igirvqs3JUjJ6G3i
        c2D3zm8o67lfMHwT2+H/Yu0fNIVWzpxHsn7nGplwcSpMJu/wnja6KInGsnwhkban
        oQyyPGw5MoQxlEg/g4GOgZGUvwp9AgMBAAECgYBKjWEef4suAvb6EwhnRDrJed4p
        wMYhyRv2rTo0hhiRE+c4IWG+b59VRjmYmsWDDjZ+jt5usWeUAs97gK/x44d31hY2
        S6N5bBc5xYqS877pOU8Un0pWmBd5mkJ1HNbO42HQJnkJGV9vbJrMj+PojiAm9x+m
        LNXfFmlZtXOGaZ8aYQJBAPOBHD12UZLA82VN/R60FFyiSg9BzFcVop3DiEcbi90h
        I4GfMovSxZ2UMQYiKQgfuUhxAYNPSniORg6+QQfxvxUCQQDAl+e5ADcBcwcgzVtx
        nuNK5KGOv/F+0/KmcrRZkbHmASKJhr5haA+M4sxf1AXwsTb7ycgNubzmCweBmBC8
        +LfJAkB9T033GzJzcTRQR8ggys9HtISkQVok3o9m3L7+yOA7Fdit1f0vE3J62043
        N9EhyyGQdAcxSdarH5xR7fqNWgzZAkBjFMNN1eJ2iGr+YSfOSGO+v+itu+nNydRn
        9VL7UY0oOyU9g2imTBbT8EoccsOrlEApQSH+jbO01a/C6CyUS5ChAkAWdpLiofi1
        G0REj5mvbpbZXgiaJael4Ct3JaUqSlogAt8eCH9dap2VNYIpPMYJ0bplEKnQOprk
        stJ+358XUp0c
        -----END PRIVATE KEY-----',
        "attributeConsumingService" => array(
            "serviceName" => "Compport",
            "serviceDescription" => "Compport",
            "requestedAttributes" => array(
                array(
                    "name" => "email",
                    "isRequired" => false,
                    "nameFormat" => "urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified",
                    "friendlyName" => "Official Email",
                    "attributeValue" => array()
                ),
                array(
                    "name" => "employee_code",
                    "isRequired" => false,
                    "nameFormat" => "urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified",
                    "friendlyName" => "Employee Code",
                    "attributeValue" => array()
                )
            )
        ),

    ),
    'idp'   => array(
        'entityId'            => 'http://testlogin.goindigo.in/adfs/services/trust',
        'reverseLogout'    =>     true,  
        'singleSignOnService' => array(
            'url' => 'https://testlogin.goindigo.in/adfs/ls/',
        ),
        'singleLogoutService' => array(
            'url' => 'https://testlogin.goindigo.in/adfs/ls/?wa=wsignout1.0',
            'binding'     => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        'x509cert'            => '-----BEGIN CERTIFICATE-----
        MIIC5jCCAc6gAwIBAgIQXTn0FrkcLL9CPemlPA3lrjANBgkqhkiG9w0BAQsFADAvMS0wKwYDVQQDEyRBREZTIFNpZ25pbmcgLSB0ZXN0bG9naW4uZ29pbmRpZ28uaW4wHhcNMTcxMDE2MTUxOTIxWhcNMjAxMDE1MTUxOTIxWjAvMS0wKwYDVQQDEyRBREZTIFNpZ25pbmcgLSB0ZXN0bG9naW4uZ29pbmRpZ28uaW4wggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDa2Rr5AWQmqtcrPlmA9Qvv5LWT/otelD39FZOcNTb/YoJbK8KHN3Muv/zzN+bJ2Ab5NR3lcAoLB124PZ66LvChc64hViZhAm56CwbO5/ApEzOPmjcAyG7x/+ikzoKGpCHWfC24LpYwHnvuUvmV2xDdbUbktLSl2wqE5iYQX1FZGvDSWMf7ApVYNx3jR24xxUN0w/TOFgm+3TNZP9deYKNmYXw66b/5wWXuK1T0+528SsIB6B4q3MCg0BYX8aMFC+G87ciI4wuG/Z2x0LPPxDXTL0CIMTjQqEfscce0k5gDVTGkT2/HIAhFjkZOCqCQMAnQk9ZrORff5o0XqhF4S8CnAgMBAAEwDQYJKoZIhvcNAQELBQADggEBAA64MFaTqQEnRXBJvG0AUWv2ctB81zyYZ9Cs9/wwYo5+msYWNuy4wqoU9yeObxW9g8BrQiC74e97G49M3mR8HKe8qOfkdfQta96Y8vQzQL4TEvHNKhQpUVVo06NeGssb338AKpLxt5D9uMq+tnhD5pmnDFKE1ZiEyuU3XiPryyYOSMfQc10akOOceTROd5t0Tp042zD9kXsmm/YuR5okm4KYlqSyRGXR3HKBgcyQ/mkZxjeDIqUH+wWBA72ra2Tuwi8L7r59KJuXDXdHwTzhd14mk1mjMrVu4CSDRSVFFmrOqgzAIHE7M+yKnJn0PjtbtLHah6fhtPAHLhmzgBe0/jE=
        -----END CERTIFICATE-----',
        'mapping_attributes' => array(
            //  'email' => 'email',
            //  'firstname' => 'firstname',
            'lastname' => 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname',
            'name' => 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name',
            'email' => 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'
        ),
    ),
);


if (isset($config[$compnay_url])) $settings = $config[$compnay_url];
