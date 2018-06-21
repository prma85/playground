app = new angular.module('app', ['ngRoute','angularUtils.directives.dirPagination']);

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider.
    when('/', {
        controller: 'MainController',
        templateUrl: 'templates/main.html'
    }).
    when('/controlefluxo', {
        controller: 'ControleFluxoController',
        templateUrl: 'templates/controlefluxo.html'
    }).
    otherwise({
        redirectTo: '/'
    });
}]);
app.controller('ControleFluxoController', function($scope, $http) {
    $http.get("172.25.129.78/controlefluxos").then(function(response) {
        $scope.controleFluxos = response.data.controleFluxos;
        $scope.jobs = response.data.jobs;
        $scope.transformacoes = response.data.transfomacoes;
        console.log(response.data);
    }, function(response) {
        console.warn(response);
    });
});

app.controller('ExecucaoTempoController', function($scope, $http) {
    $http.get("172.25.129.78/execucaotempo").then(function(response) {
        $scope.execucoesTempos = response.data.execucoesTempos;
    }, function(response) {
        console.warn(response);
    });
});

app.controller('MainController', function($scope, $http) {
   
});