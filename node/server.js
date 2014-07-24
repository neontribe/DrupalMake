///////////////
// Constants //
///////////////

var PUBLIC_ROOT = __dirname + '/public';
var ROUTES_ROOT = __dirname + '/routes';

///////////////////////////
// Imports/Instantiation //
///////////////////////////

var fs = require('fs');

var tweak = require('tweak');
var config = tweak(__dirname + '/config/config');

var express = require('express');
var app = express();

//////////////////////
// Middleware Setup //
//////////////////////

app.use(express.static(PUBLIC_ROOT));

function registerRouteFromName (name)
{
	require(ROUTES_ROOT + '/' + name)(app);
}

fs.readdirSync(ROUTES_ROOT).forEach(registerRouteFromName);

//////////////////////
// Server Listening //
//////////////////////

app.listen(9966);
