## Deploy

- Subir todos los archivos y la base de datos
- Cambiar .env con los datos de producción (Base de datos, servidor de Mail y SANCTUM_STATEFUL_DOMAINS con los dominios de la app)
- Ejecutar "artisan queue:work --queue=high,default" para el procesamiento de las colas del mail