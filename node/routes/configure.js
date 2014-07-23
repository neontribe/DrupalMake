function registerMiddleware (app)
{
	app.get('/configure', handleConfigure);
	app.post('/configure', validateNewConfig);
}

module.exports = exports = registerMiddleware;

var PUBLIC_ROOT = __dirname + '/..//public';

function handleConfigure (request, response)
{
	response.sendfile('configure.html', { root: PUBLIC_ROOT });
}

function validateNewConfig (request, response)
{
	// TODO
}