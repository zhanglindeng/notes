### [webtatic](https://webtatic.com/packages/php56/)

### error handler
- register_shutdown_function 总是运行，set_error_handler,set_exception_handler 没有处理的话，$errors 就不为 null
- set_error_handler 一般错误
- set_exception_handler 致命错误，不会捕获一般错误

### header
- header_list()
