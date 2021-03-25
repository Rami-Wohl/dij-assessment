<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\EncryptedMessage;
use App\Mail\DecryptCodeMail;
use App\Mail\MessageSent;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid;

class MessageController extends Controller
{
    public function create(): Renderable
    {
        $response = Http::get('https://pastebin.com/raw/uDzdKzGG');

        $users = json_decode($response->body());

        return view('create', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'colleague_email' => 'required|email',
            'message_content' => 'required'
        ]);

        $messageBody = $request->input('message_content');
        $cryptKey = Str::random(32);
        $token = Uuid::uuid1()->toString();
        $newEncrypter = new Encrypter($cryptKey, Config::get( 'app.cipher' ));
        $encryptedMessage = $newEncrypter->encrypt( $messageBody );
        $messageUrl = env('APP_URL') . '/message/' . $token;

        EncryptedMessage::create([
            'email' => $request->input('colleague_email'),
            'encrypted_message' => $encryptedMessage,
            'url_token' => $token,
        ]);

        Mail::to($request->input('colleague_email'))
            ->send(new MessageSent($messageUrl));
        Mail::to($request->input('colleague_email'))
            ->send(new DecryptCodeMail($cryptKey));

        return redirect()->back()->with('message', 'Je bericht is verstuurd!');
    }

    /**
     * Display the specified resource.
     *
     * @return Renderable
     */
    public function show($id) : Renderable
    {
        $messageExists = !!EncryptedMessage::where('url_token', $id)->first();
        return view('keyprompt', [
            'messageExists' => $messageExists
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @param Request $request
     * @return Renderable | RedirectResponse
     * @throws ValidationException
     */
    public function showDecrypted(string $id, Request $request)
    {
        $this->validate($request, [
            'decryption_key' => 'required',
        ]);

        $message = EncryptedMessage::where('url_token', $id)->first();
        try {
            $newEncrypter = new Encrypter($request->input('decryption_key'), Config::get('app.cipher'));
            $decryptedMessage = $newEncrypter->decrypt($message->encrypted_message);
        } catch(\RuntimeException | EncryptException | \Exception $err) {
            return redirect()->back()->with('message', 'Voer een geldig wachtwoord in');
        }

        return view('showdecrypted', [
            'message' => $decryptedMessage
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $message = EncryptedMessage::where('url_token', $id)->first();
        $message->delete();

        return redirect()->action([MessageController::class, 'create'])->with('message', 'Het bericht is verwijderd.');
    }
}
