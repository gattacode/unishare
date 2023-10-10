<?php
    class Routes{
        public const AllUsersRoute = "http://localhost/blog-tp-note-php/api/index.php/Users";
        public const UsersRoute = "http://localhost/blog-tp-note-php/api/index.php/Users/";
        public const AllArticlesRoute = "http://localhost/blog-tp-note-php/api/index.php/Articles";
        public const ArticlesRoute = "http://localhost/blog-tp-note-php/api/index.php/Articles/";
        public static function AllCommentsArticle($id){
            return Routes::ArticlesRoute . $id . '/Comments';
        }
        public static function AllCategoriesArticle($id){
            return Routes::ArticlesRoute . $id . '/Categories';
        }
        public const LoginRoute = "http://localhost/blog-tp-note-php/api/index.php/Login";
        public const CheckRoute = "http://localhost/blog-tp-note-php/api/index.php/Check/";
        public const AllCommentsRoute = "http://localhost/blog-tp-note-php/api/index.php/Comments";
        public const CommentsRoute = "http://localhost/blog-tp-note-php/api/index.php/Comments/";
        public const AllCategoriesRoute = "http://localhost/blog-tp-note-php/api/index.php/Categories";
        public const CategoriesRoute = "http://localhost/blog-tp-note-php/api/index.php/Categories/";
        
    }
?>