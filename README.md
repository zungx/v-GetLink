[![GitHub issues](https://img.shields.io/github/issues/phonglann/v-GetLink.svg?style=plastic)](https://github.com/phonglann/v-GetLink/issues) [![GitHub forks](https://img.shields.io/github/forks/phonglann/v-GetLink.svg?style=plastic)](https://github.com/phonglann/v-GetLink/network) [![GitHub stars](https://img.shields.io/github/stars/phonglann/v-GetLink.svg?style=plastic)](https://github.com/phonglann/v-GetLink/stargazers) [![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=plastic)](https://raw.githubusercontent.com/phonglann/v-GetLink/master/LICENSE)
## `v-GetLink` Thư viện hỗ trợ get link

### Mục Lục:
[I.  Đôi lời giới thiệu](#GioiThieu)

[II. Những server được hỗ trợ](#HoTro)

[III. Hướng dẫn sử dụng](#HuongDan)
- [Cài đặt](#CaiDat)
- [Sử dụng](#SuDung)

[IV. Liên hệ](#LienHe)

<a name="GioiThieu"></a>
### I. Giới Thiệu:
Nhu cầu viết web xem phim, nghe nhạc,... hiện nay đang được rất nhiều giới trẻ ưu chuộng, tuy nhiên việc sở hữu một CSDL đầy đủ thì lại là một vấn đề nan giải dành cho những lập trình viên. Vì thế, người dùng họ thường chọn cách clone dữ liệu về website của mình, nhưng công việc viết mã, kiểm tra mã,... khiến cho công việc đơn giản lại tốn rất nhiều thời gian. Chính vì thế, thư viện hỗ trợ get link này đã ra đời nhằm giúp giải quyết những vấn đề trên một cách nhanh chóng.

Thư viện này được viết ra với tiêu chí cho người dùng dễ dàng sử dụng nhất, chỉ với 1 dòng, bạn đã có thể sở hữu gần như đầy đủ thông tin của một bài hát, video,... Tuy nhiên nó vẫn chưa phải là hoàn hảo, thư viện được viết chỉ với một cá nhân, việc crash code, lỗi là điều không thể tránh khỏi trong quá trình sử dụng, vì vậy mong mọi người khi sử dụng gặp lỗi hãy thông báo lại qua github, tình trạng lỗi sẽ cố gắng fix lại trong những bản cập nhật tiếp theo.

<a name="HoTro"></a>
### II. Những Server Được Hỗ Trợ:
- `ZingMp3` (http://mp3.zing.vn): `Hỗ trợ bài hát, video`
- `NCT` (http://nhaccuatui.com): `Hỗ trợ bài hát, video`
- `vNCT` (http://v.nhaccuatui.com): `Hỗ trợ loại Phim, Hoạt Hình, Video`

<a name="HuongDan"></a>
### III. Hướng Dẫn Sử Dụng (Cần composer):
<a name="CaiDat"></a>
### Cài Đặt:
`Bước 1:`
```sh
composer require phonglan/v-getlink
```

`Bước 2:`
```sh
composer dump-autoload -o
```

`Bước 3 (Tùy):`

Nếu bạn đang sử dụng một php framework thì không cần thực hiện bước này và ngược lại nếu bạn không sử dụng php framework nào thì cần phải thêm đoạn code này vào file `index.php` (cùng cấp thư mục với folder `vendor`) để sử dụng tính năng autoload:
```sh
require_once('vendor/autoload.php');
```

<a name="SuDung"></a>
### Sử Dụng:
`Bước 1:` Khai báo thư viện cần sử dụng theo mẫu dưới:
```sh
use GetLink\$Server
```
Trong đó `$Server` là [tên thư viện](#HoTro)

`Bước 2:` Get link từng server:
```sh
// Get link Nhaccuatui
echo NCT::get('http://www.nhaccuatui.com/video/banh-troi-nuoc-hoang-thuy-linh.RCOvniheFw1h7.html');

// Get link v.Nhaccuatui
echo vNCT::get('http://v.nhaccuatui.com/phim/chien-nao-ma-kia.RiDUM8FWaoTx.html?key=Lw6cR3cu4Fle6');

// Get link ZingMp3
echo ZingMp3::get('http://mp3.zing.vn/video-clip/Mot-Lan-La-Tot-Roi-Duong-Tong-Vi/ZW7O8EDO.html');
```

`Tham số tùy chọn (array):` Nếu không có tham số tùy chọn, thì thư viện sẽ trả về tất cả mọi thông tin thuộc về URL nhưng nếu chỉ muốn lấy những thông tin cần thiết thì:
```sh
echo vNCT::get('http://v.nhaccuatui.com/phim/chien-nao-ma-kia.RiDUM8FWaoTx.html?key=Lw6cR3cu4Fle6', ['image', 'has720']);
// Return: {"image":"http:\/\/avatar.nct.nixcdn.com\/mv\/2012\/02\/06\/cfiMPzRmsk_640.jpg", "has720": false}

echo ZingMp3::get('mp3.zing.vn/bai-hat/-Mot-Lan-La-Tot-Roi-Duong-Tong-Vi/ZW7O8EDO.html', ['source' => [128, 320], "song_id"]);
// Return: {"128":"http:\/\/api.mp3.zing.vn\/api\/mobile\/source\/song\/LGJGTLGNQAXLNLQTLDJTDGLG","320":"http:\/\/api.mp3.zing.vn\/api\/mobile\/source\/song\/LGJGTLGNQAXLNLQTVDGTDGLG","song_id":1075461715}
```

`Lưu ý:` Tham số tùy chọn dưới theo giá trị server trả về, nếu không biết giá trị trả về các bạn có thể bỏ qua `tham số tùy chọn` để xem những giá trị mà server trả về

<a name="LienHe"></a>
### IV. Liên Hệ:
- Tác giả: `Phong Lẩn`
- Facebook: `https://fb.com/phonglannnnn`
- Tên thư viện: `v-GetLink`
- Packagist: `https://packagist.org/packages/phonglan/v-getlink`
