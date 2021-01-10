<?php
/**
 * This file is part of Monda-PHP.
 *
 */

namespace app\modules\admin\action;

use app\middleware\WebMiddleWare;
use app\modules\Url;
use app\modules\User;
use app\modules\UserVo;
use app\modules\UserVo2;
use app\modules\UserVo3;

use framework\cache\CacheFactory;
use framework\cache\ICache;
use framework\Container;
use framework\Controller;
use framework\crypt\Base64Crypt;
use framework\crypt\Crypt;
use framework\crypt\RSACrypt;
use framework\db\DB;
use framework\exception\HeroException;
use framework\log\Log;
use framework\request\RequestInterface;
use framework\session\Session;
use framework\util\Loader;
use framework\util\Result;

/**
 * Class UserController.
 */
class IndexAction extends Controller
{
    public function index(RequestInterface $request): array
    {
        $a = CacheFactory::get()->set('a', [1, 2]);
        $c = CacheFactory::get()->get('a');
        //Log::info("hello——world");
        //Cookie::set("s_hello", [1, 2, 3]);
        return [
            'ip' => $request->getClientIp(),
            'method' => $request->getMethod(),
            'url' => $request->getUri(),
            'a' => $a,
            'c' => $c,
        ];
    }

    public function user(RequestInterface $request, int $i): array
    {
        $user = Loader::service(User::class);
        $user2 = Loader::service(User::class);
        return [
            'user' => $user->name,
            'isSame' => $user === $user2,
        ];
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws HeroException
     */
    public function index2(RequestInterface $request): array
    {
        throw new HeroException('aaa');
    }

    public function index4(RequestInterface $request): array
    {
        return [
            'xx' => config('cache'),
        ];
    }

    public function index5(RequestInterface $request): array
    {
        return [
            'xx' => Container::getContainer()->get('config')->get('cache.channels.redis'),
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function index6(): array
    {
        $this->middleware = [WebMiddleWare::class];
        return [
            111,
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function index7(): array
    {
        $v = config('database.aa');
        /* @var ICache $cache */
        return [
            User::query()->count(),
            Url::query()->count(),
            User::query()->count(),
            Url::query()->count(),
            DB::table('bi_url', 'bi')->count(),
            DB::table('admin_user', 'default')->count(),
        ];
    }

    /**
     * @throws \Exception
     */
    public function index8(): string
    {
        return '111';
    }

    /**
     * @return string
     */
    public function index9(): string
    {
        return view('admin/index', [
            'hello' => 'nihao',
            'php' => '世界最好的php'
        ]);
    }

    /**
     * @param UserVo $userVo
     * @return array
     */
    public function index10(UserVo $userVo): array
    {
        return [
            'a' => 1,
            'name' => $userVo->getName(),
            'age' => $userVo->getAge(),
        ];
    }

    /**
     * @param UserVo2 $userVo
     * @return array
     */
    public function index11(UserVo2 $userVo): array
    {
        return [
            'name' => $userVo->getName(),
            'age' => $userVo->getAge(),
        ];
    }

    /**
     * @param UserVo3 $userVo
     * @return array
     */
    public function index12(UserVo3 $userVo): array
    {
        return [
            'name' => $userVo->getName(),
            'age' => $userVo->getAge(),
        ];
    }

    public function index13(): Result
    {
        return Result::ok()->data([
            '1' => 2
        ]);
    }

    public function index14(): Result
    {
        $password = 'a123456';

        $publicKey = config('rsa.publicKey');
        $privateKey = config('rsa.privateKey');
        $str = (new RSACrypt())->encryptByPublicKey($password, $publicKey);
        $a = Crypt::encrypt('a12345678', '123456', 2);
        $c = Base64Crypt::encrypt('a12345678', '123456', 2);

        return Result::ok()->data([
            'public' => $publicKey,
            'private' => $privateKey,
            'crypt' => $str,
            'password' => (new RSACrypt())->decryptByPrivateKey($str, $privateKey),
            'a' => $a,
            'b' => Crypt::decrypt($a, '123456'),
            'c' => $c,
            'd' => Base64Crypt::decrypt($c, '123456'),
        ]);
    }

    public function index15(): array
    {
        Session::start();

        Session::set('a1', [2, 'a', 'b']);
        return [
//            Session::get('aaa'),
            Session::get('a1'),
//            Session::get('b1', function () {
//                return 11;
//            }),
        ];
    }

    public function index16(): void
    {
        $st = time();
        foreach (range(1, 5) as $i) {
            $output = $i * 2;
            sleep(1);
            echo $output . "\n";
        }
        echo '-----' . PHP_EOL;
        echo time() - $st;
        die;
    }

    public function index18(RequestInterface $request): Result
    {
        $a = 11;
        try {
            DB::transaction('bi', static function () use ($a) {
                Url::query()->where('id', '015ff2862c00c2d9a4')->update(['sort' => 1000]);
                throw new HeroException('测试');
            }, 1);
        } catch (\Throwable $e) {
            echo $e->getMessage();
            die;
        }
        return Result::ok()->data([
            'uid' => $request->getClientIp(),
        ]);
    }

    public function index19(): string
    {
        Log::debug('{a} hello', ['a' => '你好']);
        return 1;
    }

    /**
     * 上传
     * @param RequestInterface $request
     * @return string
     * @throws \Exception
     */
    public function upload(RequestInterface $request): string
    {
        $request->getUploadFile('src')->move(RUNTIME_PATH . '/upload');
        return 1;
    }

    /**
     * 上传
     * @param RequestInterface $request
     * @return string
     * @throws \Exception
     */
    public function uploadValid(RequestInterface $request): string
    {
        $request->getUploadFile('src')->isValid([
            'allow_ext' => 'jpg',
            //图片的最大宽度, 0没有限制
            'max_width' => 0,
            //图片的最大高度, 0没有限制
            'max_height' => 0,
            //文件的最大尺寸
            'max_size' => 1024000,     /* 文件size的最大 1MB */
        ])->move(RUNTIME_PATH . '/upload');
        return 1;
    }
}
