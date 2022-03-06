<?php

namespace Jalno\Http\Contracts;

use dnj\Filesystem\Contracts\IFile;

/**
 * @phpstan-type ProxyOptions array{"type": "http"|"https"|"socks4"|"socks5","hostname": string,"port": int,"username"?:string,"password"?:string}
 * @phpstan-type Options array{
 * 		base_uri?: string,
 * 		allow_redirects?: bool,
 * 		auth?: array{username: string,password: string}|string,
 * 		body?: string|array<string,mixed>|IFile,
 * 		cookies?: string,
 * 		connect_timeout?: int,
 * 		debug?: bool,
 * 		delay?: int,
 * 		form_params?: array<string,mixed>,
 * 		headers?:array<string,string>,
 * 		http_errors?: bool,
 * 		json?: array<string,mixed>,
 * 		multipart?: array<string,mixed>,
 * 		proxy?: ProxyOptions,
 * 		query?: array<string,mixed>,
 * 		ssl_verify?: bool,
 * 		timeout?: int,
 * 		save_as?: IFile,
 * 		outgoing_ip?: string
 * }
 */
interface IHandler
{
    /**
     * @param Options $options
     */
    public function fire(IRequest $request, array $options): IResponse;
}
