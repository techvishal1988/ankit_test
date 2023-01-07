<?php
$config=[] ;
$config['azuread'] = array(
    'debug' => true,
    'sp'    => array(
        'entityId'                 => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_metadata',
        'assertionConsumerService' => array(
            'url' => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_login?acs',
        ),
        'singleLogoutService'      => array(
            'url' => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_login?sls',
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

$config['perf2']  = array(
    'debug' => true,
    'sp'    => array(
        'entityId'                 => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_metadata',
        'assertionConsumerService' => array(
            'url' => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_login?acs',
        ),
        'singleLogoutService'      => array(
            'url' => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_login?sls',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
    ),
    'idp'   => array(
        'entityId'            => 'https://app.onelogin.com/saml/metadata/1837b935-5b1b-4c93-91e1-384652979816',
        'singleSignOnService' => array(
            'url' => 'https://compp-dev.onelogin.com/trust/saml2/http-redirect/sso/1837b935-5b1b-4c93-91e1-384652979816',
        ),
        'singleLogoutService' => array(
            'url' => 'https://compp-dev.onelogin.com/trust/saml2/http-redirect/slo/1042878',
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
-----END CERTIFICATE-----
',
    ),
);

$config['perf.com']  = array(
    'debug' => true,
    'sp'    => array(
        'entityId'                 => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_metadata',
        'assertionConsumerService' => array(
            'url' => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_login?acs',
        ),
        'singleLogoutService'      => array(
            'url' => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_login?sls',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
    ),
    'idp'   => array(
        'entityId'            => 'https://app.onelogin.com/saml/metadata/1837b935-5b1b-4c93-91e1-384652979816',
        'singleSignOnService' => array(
            'url' => 'https://compp-dev.onelogin.com/trust/saml2/http-redirect/sso/1837b935-5b1b-4c93-91e1-384652979816',
        ),
        'singleLogoutService' => array(
            'url' => 'https://compp-dev.onelogin.com/trust/saml2/http-redirect/slo/1042878',
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
-----END CERTIFICATE-----
',
    ),
);

$config['onelogin']  = array(
    'debug' => true,
    'sp'    => array(
        'entityId'                 => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_metadata',
        'assertionConsumerService' => array(
            'url' => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_login?acs',
        ),
        'singleLogoutService'      => array(
            'url' => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_login?sls',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
    ),
    'idp'   => array(
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
-----END CERTIFICATE-----
',
    ),
);

$config['oneloginlocal']  = array(
    'debug' => true,
    'sp'    => array(
        'entityId'                 => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_metadata',
        'assertionConsumerService' => array(
            'url' => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_login?acs',
        ),
        'singleLogoutService'      => array(
            'url' => $_SERVER['USER_PORTAL_BASE_URL'] . 'home/sso_login?sls',
        ),
        'NameIDFormat'             => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
    ),
    'idp'   => array(
        'entityId'            => 'https://app.onelogin.com/saml/metadata/1c0732b5-c3ab-449d-b058-b77a213bc33b',
        'singleSignOnService' => array(
            'url' => 'https://compp-dev.onelogin.com/trust/saml2/http-post/sso/1c0732b5-c3ab-449d-b058-b77a213bc33b',
        ),
        'singleLogoutService' => array(
            'url' => 'https://compp-dev.onelogin.com/trust/saml2/http-redirect/slo/1028270',
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
-----END CERTIFICATE-----
',
    ),
);

$config['default'] = array(
    // If 'strict' is True, then the PHP Toolkit will reject unsigned
    // or unencrypted messages if it expects them signed or encrypted
    // Also will reject the messages if not strictly follow the SAML
    // standard: Destination, NameId, Conditions ... are validated too.
    'strict'  => true,

    // Enable debug mode (to print errors)
    'debug'   => false,

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


//$settings=$config['azuread'];
$settings=$config['onelogin'];
$settings=$config['perf2'];
