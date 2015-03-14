# widgetgrid-web

This is the companion app to [widgetgrid-ar](https://github.com/mattbasta/widgetgrid-ar).

Note that you should NOT use this in production or derive any production code from it. There are huge problems with it, including:

- Passwords are only SHA1 hashed
- There's probably XSS abound
- There's probably SQL injection attacks that are possible


## The "old" endpoint

There's an endpoint in here called "old". As far as I can tell, this was an experiment that originally gave me the idea for the project. It allowed web widgets to execute some basic actions on the server using a PHP library called "j4p5". It was a poorly-executed idea (Google Gears support, anyone?), but it had some interesting stuff in there nonetheless.

Consider the endpoint an exploration of my thought process.


## Foundation

The code is based on [interchange](https://github.com/serverboy/Interchange). The particular version that is used is unknown. Additionally, [cloud](https://github.com/serverboy/cloud) is used as an ORM.


## Licensing

Code in the `libraries/` directory may be subject to non-free licenses. In particular, a SimpleGeo API may not be public domain.

All other code is free to use under [CC0](https://creativecommons.org/publicdomain/zero/1.0/).

