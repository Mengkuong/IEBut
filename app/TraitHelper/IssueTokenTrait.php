<?php

namespace App\TraitHelper;

use Illuminate\Http\Request;

trait IssueTokenTrait
{
    public function issueToken(Request $request, $username, $grantType)
    {
        $res = app()->handle($request->create('oauth/token', 'POST', [
            'grant_type' => $grantType,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => "",
            'username'=>$username,
            'password' =>$request->password

        ]));
        return $res->getContent();
    }
}
