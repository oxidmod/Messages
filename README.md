Test task for SMSEdge.io
========================

[![Build Status](https://travis-ci.org/oxidmod/Messages.svg?branch=master)](https://travis-ci.org/oxidmod/Messages)
[![Coverage Status](https://coveralls.io/repos/github/oxidmod/Messages/badge.svg)](https://coveralls.io/github/oxidmod/Messages)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/oxidmod/Messages/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/oxidmod/Messages/?branch=master)

**How to install**

1. git clone https://github.com/oxidmod/Messages.git
2. cd Messages
3. php composer.phar install
4. Set DATABASE_URL in generated .env file in the project root
5. php bin/console doctrine:database:create
6. php bin/console doctrine:migration:migrate -n
7. start server php bin/console server:start
8. Open http://localhost:8000 in your browser
