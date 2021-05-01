function ServAuth($http, $q) {

    this.Authenticate = function (oRequest) {
        var deferred = $q.defer();
        try {
            var respuesta = $http({
                method: 'GET',
                url: '/api/post.php?user='+oRequest.user+'&pass='+oRequest.pass+''
            });

            respuesta.then(
                function (response) {
                    deferred.resolve(response.data);
                },
                function (errorPayload) {
                    deferred.reject('Error :' + errorPayload.Data);
                });
        } catch (err) {
            deferred.reject('Error :' + err.message);
        }

        return deferred.promise;
    } 

    this.getUsers = function (bd) {
        var deferred = $q.defer();
        try {
            var respuesta = $http({
                method: 'GET',
                url: '/api/post.php',
                dataType: "json"
            });

            respuesta.then(
                function (response) {
                    deferred.resolve(response.data);
                },
                function (errorPayload) {
                    deferred.reject(errorPayload);
                });
        } catch (err) {
            deferred.reject('Error :' + err.message);
        }

        return deferred.promise;
    }

    this.getUser = function (request) {
        var deferred = $q.defer();
        try {
            var respuesta = $http({
                method: 'POST',
                url: '/API_clientes/api_users/readOne.php',
                dataType: "json",
                data: request
            });

            respuesta.then(
                function (response) {
                    deferred.resolve(response.data);
                },
                function (errorPayload) {
                    deferred.reject(errorPayload);
                });
        } catch (err) {
            deferred.reject('Error :' + err.message);
        }

        return deferred.promise;
    }

    this.putUsers = function (oRequest) {
        var deferred = $q.defer();
        try {
            var respuesta = $http({
                method: 'POST',
                url: '/API_clientes/api_users/create.php',
                data: oRequest,
                dataType: "json"
            });

            respuesta.then(
                function (response) {
                    deferred.resolve(response);
                },
                function (errorPayload) {
                    deferred.reject(errorPayload);
                });
        } catch (err) {
            deferred.reject('Error :' + err.message);
        }

        return deferred.promise;
    }

    this.deleteUsers = function (oRequest) {
        var deferred = $q.defer();
        try {
            var respuesta = $http({
                method: 'POST',
                url: '/API_clientes/api_users/delete.php',
                data: oRequest,
                dataType: "json"
            });

            respuesta.then(
                function (response) {
                    deferred.resolve(response);
                },
                function (errorPayload) {
                    deferred.reject('Error :' + errorPayload.Data);
                });
        } catch (err) {
            deferred.reject('Error :' + err.message);
        }

        return deferred.promise;
    }

    this.updateUsers = function (oRequest) {
        // console.log(oRequest);
        var deferred = $q.defer();
        try {
            var respuesta = $http({
                method: 'POST',
                url: '/API_clientes/api_users/update.php',
                data: oRequest,
                dataType: "json"
            });

            respuesta.then(
                function (response) {
                    deferred.resolve(response);
                },
                function (errorPayload) {
                    deferred.reject(errorPayload);
                });
        } catch (err) {
            deferred.reject('Error :' + err.message);
        }
        return deferred.promise;
    }

    this.forgetPassword = function (request) {
        var deferred = $q.defer();
        try {
            var respuesta = $http({
                method: 'POST',
                url: '/API_clientes/api_users/change_pass.php',
                dataType: "json",
                data: request
            });

            respuesta.then(
                function (response) {
                    deferred.resolve(response.data);
                },
                function (errorPayload) {
                    deferred.reject(errorPayload);
                });
        } catch (err) {
            deferred.reject('Error :' + err.message);
        }

        return deferred.promise;
    }
} 

function ServBlog($http, $q){

    this.getArticles = function () {
        var deferred = $q.defer();
        try {
            var respuesta = $http({
                method: 'GET',
                url: '/api/article.php',
                dataType: "json"
            });

            respuesta.then(
                function (response) {
                    deferred.resolve(response.data);
                },
                function (errorPayload) {
                    deferred.reject(errorPayload);
                });
        } catch (err) {
            deferred.reject('Error :' + err.message);
        }

        return deferred.promise;
    }

    this.getArticle = function (id) {
        var deferred = $q.defer();
        try {
            var respuesta = $http({
                method: 'POST',
                url: '/API_clientes/api_users/readOne.php?id='+id
            });

            respuesta.then(
                function (response) {
                    deferred.resolve(response.data);
                },
                function (errorPayload) {
                    deferred.reject(errorPayload);
                });
        } catch (err) {
            deferred.reject('Error :' + err.message);
        }

        return deferred.promise;
    }

    this.putArticle = function (oRequest) {
        var deferred = $q.defer();
        try {
            var respuesta = $http({
                method: 'POST',
                url: '/api/article.php',
                data: oRequest,
                dataType: "json"
            });

            respuesta.then(
                function (response) {
                    deferred.resolve(response);
                },
                function (errorPayload) {
                    deferred.reject(errorPayload);
                });
        } catch (err) {
            deferred.reject('Error :' + err.message);
        }

        return deferred.promise;
    }
}

angular
    .module('inspinia')
    .service('ServAuth', ServAuth)
    .service('ServBlog', ServBlog);