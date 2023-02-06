<?php
/**
 * @OA\Info(
 *         version="1.0.0",
 *         title="RED6SIX API",
 *         description="<h1>Description</h1>",
 * ),
 *
 * @OA\Server(url="https://test-api.red6six.com"),
 * @OA\Server(url="http://127.0.0.1:8000"),
 *
 * @OA\PathItem(
 *     path="/"
 * ),
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * ),
 */
