const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/style.scss", "public/css")

    // page(first)
    .sass("resources/sass/page/first.scss", "public/css/page")

    // page(home)
    .sass("resources/sass/page/home/home.scss", "public/css/page/")

    // page(contact)
    .sass("resources/sass/page/contact.scss", "public/css/page")

    // page(auth)
    .sass("resources/sass/page/auth/login.scss", "public/css/page/auth")
    .sass("resources/sass/page/auth/register.scss", "public/css/page/auth")
    .sass("resources/sass/page/auth/password.scss", "public/css/page/auth")

    // page (user)
    .sass(
        "resources/sass/page/user/event/event.scss",
        "public/css/page/user/event"
    )
    .sass(
        "resources/sass/page/user/event/event_show.scss",
        "public/css/page/user/event"
    )
    .sass(
        "resources/sass/page/user/event/event_edit.scss",
        "public/css/page/user/event"
    )
    .sass(
        "resources/sass/page/user/event/event_create.scss",
        "public/css/page/user/event"
    )
    .sass(
        "resources/sass/page/user/post/post.scss",
        "public/css/page/user/post"
    )
    .sass(
        "resources/sass/page/user/post/post_show.scss",
        "public/css/page/user/post"
    )

    // setting
    .sass(
        "resources/sass/page/user/setting/setting.scss",
        "public/css/page/user/setting"
    )
    .sass(
        "resources/sass/page/user/setting/setting_edit.scss",
        "public/css/page/user/setting"
    )
    .sass(
        "resources/sass/page/user/setting/setting_withdrawal.scss",
        "public/css/page/user/setting"
    )

    // page(place)
    .sass("resources/sass/page/user/place.scss", "public/css/page/user")

    // page(type)
    .sass("resources/sass/page/user/type.scss", "public/css/page/user")
    .sass("resources/sass/page/user/select.scss", "public/css/page/user");
