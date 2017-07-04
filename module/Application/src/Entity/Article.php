<?php
    namespace Application\Entity;

    Class Article {
        private $id_article;
        private $name_article;
        private $title_article;
        private $text_article;
        private $commentaire_article;
        private $user_article;
        private $page_id_article;

        /**
         * Get the value of foo container
         *
         * @return AbcClass
         */
        public function getIdArticle()
        {
            return $this->id_article;
        }

        /**
         * Set the value of foo container
         *
         * @param AbcClass id_article
         *
         * @return self
         */
        public function setIdArticle(AbcClass $id_article)
        {
            $this->id_article = $id_article;

            return $this;
        }

        /**
         * Get the value of Name Article
         *
         * @return mixed
         */
        public function getNameArticle()
        {
            return $this->name_article;
        }

        /**
         * Set the value of Name Article
         *
         * @param mixed name_article
         *
         * @return self
         */
        public function setNameArticle($name_article)
        {
            $this->name_article = $name_article;

            return $this;
        }

        /**
         * Get the value of Title Article
         *
         * @return mixed
         */
        public function getTitleArticle()
        {
            return $this->title_article;
        }

        /**
         * Set the value of Title Article
         *
         * @param mixed title_article
         *
         * @return self
         */
        public function setTitleArticle($title_article)
        {
            $this->title_article = $title_article;

            return $this;
        }

        /**
         * Get the value of Text Article
         *
         * @return mixed
         */
        public function getTextArticle()
        {
            return $this->text_article;
        }

        /**
         * Set the value of Text Article
         *
         * @param mixed text_article
         *
         * @return self
         */
        public function setTextArticle($text_article)
        {
            $this->text_article = $text_article;

            return $this;
        }

        /**
         * Get the value of Commentaire Article
         *
         * @return mixed
         */
        public function getCommentaireArticle()
        {
            return $this->commentaire_article;
        }

        /**
         * Set the value of Commentaire Article
         *
         * @param mixed commentaire_article
         *
         * @return self
         */
        public function setCommentaireArticle($commentaire_article)
        {
            $this->commentaire_article = $commentaire_article;

            return $this;
        }

        /**
         * Get the value of User Article
         *
         * @return mixed
         */
        public function getUserArticle()
        {
            return $this->user_article;
        }

        /**
         * Set the value of User Article
         *
         * @param mixed user_article
         *
         * @return self
         */
        public function setUserArticle($user_article)
        {
            $this->user_article = $user_article;

            return $this;
        }

        /**
         * Get the value of Page Id Article
         *
         * @return mixed
         */
        public function getPageIdArticle()
        {
            return $this->page_id_article;
        }

        /**
         * Set the value of Page Id Article
         *
         * @param mixed page_id_article
         *
         * @return self
         */
        public function setPageIdArticle($page_id_article)
        {
            $this->page_id_article = $page_id_article;

            return $this;
        }

    }
