<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Question;
use App\Models\Match;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\League;
use App\Models\Page;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){

        $reference = @$_GET['reference'];

        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle  = 'Home';
        $sections   = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();
        $categories = Category::where('status', 1)->with('leagues')->latest()->get();
        $matches = Match::runningForUser()->latest()
        ->with([
            'questions'=>function($q){
                $q->where('status', 1);
            },
            'questions.options'=>function($q){
                $q->where('status', 1);
            }
        ])
        ->paginate(getPaginate());
        return view($this->activeTemplate . 'home', compact('pageTitle','sections','categories','matches'));
    }

    public function matchesByLeague($slug, $id)
    {
        $league     = League::where('status', 1)->findOrFail($id);
        $sections   = Page::where('tempname', $this->activeTemplate)->where('slug','home')->first();
        $matches    = Match::runningForUser()->where('league_id', $league->id)
        ->with([
            'questions'=>function($q){
                $q->where('status', 1);
            },
            'questions.options'=>function($q){
                $q->where('status', 1);
            }
        ])
        ->paginate(getPaginate());
        $pageTitle  = $league->name.' - Matches';
        $categories = Category::where('status', 1)->with('leagues')->latest()->get();
        return view($this->activeTemplate . 'home', compact('pageTitle','categories','matches','sections'));
    }

    public function matchDetails($slug, $id)
    {
        $match      = Match::runningForUser()->findOrFail($id);
        $questions  = Question::where('status', 1)->where('match_id', $match->id)->with(['options'=>function($q){
            $q->where('status', 1);
        }])->paginate(getPaginate());

        $pageTitle  = $match->name.' - Questions';
        $categories = Category::where('status', 1)->with('leagues')->latest()->get();

        return view($this->activeTemplate . 'match_details', compact('pageTitle','categories','questions'));
    }

    public function blogs()
    {
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','blog')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'BLOG';
            $page->slug = 'blog';
            $page->save();
        }

        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','blog')->first();
        $pageTitle = 'Blogs';

        $blogs = Frontend::where('data_keys','blog.element')->latest()->paginate(getPaginate());
        $emptyMessage = 'No data found';

        return view($this->activeTemplate . 'blogs', compact('pageTitle','blogs','emptyMessage','sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {

        $pageTitle = "Contact Us";
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','contact')->first();
        return view($this->activeTemplate . 'contact',compact('pageTitle','sections'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blogDetails($id, $slug){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        $recentPosts = Frontend::where('data_keys','blog.element')->where('id', '!=', $id)->latest()->limit(10)->get();
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle','recentPosts'));
    }


    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json(['success' => 'Cookie accepted successfully']);
    }

    public function subscriberStore(Request $request) {

        $validate = Validator::make($request->all(),[
            'email' => 'required|email|unique:subscribers',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()]);
        }

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response()->json(['success' => 'Subscribed successfully!']);
    }

    public function policyDetails($slug,$id)
    {
        $policyDetails = Frontend::where('data_keys', 'policy_pages.element')->findOrFail($id);
        $pageTitle = $policyDetails->data_values->title;

        return view($this->activeTemplate.'policy',compact('pageTitle', 'policyDetails'));
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

}
