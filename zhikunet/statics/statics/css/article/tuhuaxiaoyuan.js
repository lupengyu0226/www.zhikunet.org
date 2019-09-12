function ObjectAD() {
  /* Define Variables*/
  this.ADID        = 0;
  this.ADType      = 0;
  this.ADName      = "";
  this.ImgUrl      = "";
  this.ImgWidth    = 0;
  this.ImgHeight   = 0;
  this.FlashWmode  = 0;
  this.LinkUrl     = "";
  this.LinkTarget  = 0;
  this.LinkAlt     = "";
  this.Priority    = 0;
  this.CountView   = 0;
  this.CountClick  = 0;
  this.InstallDir  = "";
  this.ADDIR       = "";
}

function CodeZoneAD(_id) {
  /* Define Common Variables*/
  this.ID          = _id;
  this.ZoneID      = 0;

  /* Define Unique Variables*/

  /* Define Objects */
  this.AllAD       = new Array();
  this.ShowAD      = null;

  /* Define Functions */
  this.AddAD       = CodeZoneAD_AddAD;
  this.GetShowAD   = CodeZoneAD_GetShowAD;
  this.Show        = CodeZoneAD_Show;

}

function CodeZoneAD_AddAD(_AD) {
  this.AllAD[this.AllAD.length] = _AD;
}

function CodeZoneAD_GetShowAD() {
  if (this.ShowType > 1) {
    this.ShowAD = this.AllAD[0];
    return;
  }
  var num = this.AllAD.length;
  var sum = 0;
  for (var i = 0; i < num; i++) {
    sum = sum + this.AllAD[i].Priority;
  }
  if (sum <= 0) {return ;}
  var rndNum = Math.random() * sum;
  i = 0;
  j = 0;
  while (true) {
    j = j + this.AllAD[i].Priority;
    if (j >= rndNum) {break;}
    i++;
  }
  this.ShowAD = this.AllAD[i];
}

function CodeZoneAD_Show() {
  if (!this.AllAD) {
    return;
  } else {
    this.GetShowAD();
  }

  if (this.ShowAD == null) return false;
  document.write(this.ShowAD.ADIntro);
}

var ZoneAD_1151 = new CodeZoneAD("ZoneAD_1151");
ZoneAD_1151.ZoneID      = 1151;
ZoneAD_1151.ZoneWidth   = 0;
ZoneAD_1151.ZoneHeight  = 0;
ZoneAD_1151.ShowType    = 1;

var objAD = new ObjectAD();
objAD.ADID           = 1155;
objAD.ADType         = 4;
objAD.ADName         = "内容页底部图画校园";
objAD.ImgUrl         = "";
objAD.InstallDir     = "http://www.exam8.com/";
objAD.ImgWidth       = 0;
objAD.ImgHeight      = 0;
objAD.FlashWmode     = 0;
objAD.ADIntro        = "<div class=\"tuhua\"><div class=\"tuhuaxiaoyuan\"><a href=\"http://www.exam8.com/school/tietu/\" target=\"_blank\">图画校园</a></div><div class=\"sildPicBar\" id=\"sildPicBar\"><span class=\"pre\"></span><ul id=\"dot\"></ul><span class=\"next\"></span></div><div class=\"clear\"></div>\n\r<div class=\"wrap\">\n\r<div class=\"cntwrap\" id=\"cnt-wrap\">\n\r  <div class=\"cnt\" id=\"cnt\">\n\r    <ul>\n\r      <li>\n\r          <a href=\"http://www.exam8.com/school/tietu/201012/1725091.html\" target=\"_blank\"><img height=\"90\" src=\n\r  \"http://www.exam8.com/school/UploadFiles/201012/2010121616371702.jpg\" width=\"130\" border=\"0\" /><br />\n\r                <div>刘亦菲惊艳写真曝光</div></a>\n\r                  <a href=\"http://www.exam8.com/school/tietu/201012/1718730.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010121115261680.jpg\" width=\"130\" border=\"0\" /><br />\n\r              <div>张含韵转成熟路线</div></a>\n\r              </li>\n\r              <li>\n\r           <a href=\"http://www.exam8.com/school/tietu/201012/1718430.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010121019040337.jpg\" width=\"130\" border=\"0\" /><br />\n\r              <div>尚雯婕旧衣新穿宣扬环保</div></a> \n\r                <a href=\"http://www.exam8.com/school/tietu/201012/1718427.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010122617384210.jpg\"\n\r				 width=\"130\" border=\"0\" /><br />   <div>范玮琪写真气质清新</div></a></li>\n\r                <li>\n\r                 \n\r <a href=\"http://www.exam8.com/school/tietu/201012/1718468.html\" target=\"_blank\"><img height=\"90\" src=\n\r  \"http://www.exam8.com/school/UploadFiles/201012/2010121019523682.jpg\"\n\r   width=\"130\" border=\"0\" /><br />\n\r                <div>李诗英“奢华的性感”</div></a>    \n\r         \n\r            \n\r        <a href=\"http://www.exam8.com/school/tietu/201012/1718642.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010121111454631.jpg\" width=\"130\" border=\"0\" /><br />\n\r              <div>“晴天娃娃”江语晨写真</div></a>\n\r               \n\r        \n\r              </li>\n\r              <li>\n\r                <a href=\"http://www.exam8.com/school/tietu/201012/1718636.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010121111322201.jpg\" width=\"130\" border=\"0\" /><br />\n\r              <div>黄奕拍摄写真OL范十足</div></a>         \n\r            <a href=\"http://www.exam8.com/school/tietu/201012/1725248.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010121617275482.jpg\" width=\"130\" border=\"0\" /><br /><div>柳岩超诱惑写真曝光</div></a>\n\r            </li>\n\r            <li>\n\r              <a href=\"http://www.exam8.com/school/tietu/201012/1717207.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010120916485736.jpg\" width=\"130\" border=\"0\" /><div>男人无法抵挡的旗袍诱惑</div></a>  \n\r     <a href=\"http://www.exam8.com/school/tietu/201007/1456463.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201007/2010071610462451.jpg\" width=\"130\" border=\"0\" /><br /><div>新一代玉女：石原里美</div></a>  \n\r     </li>\n\r\n\r    <li>\n\r      <a href=\"http://www.exam8.com/school/tietu/201007/1459480.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201007/2010071910182993.jpg\" width=\"130\" border=\"0\" /><div>张柏芝产后登时尚杂志</div></a>\n\r   <a href=\"http://www.exam8.com/school/tietu/201007/1456458.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201007/2010071610375988.jpg\"\n\r				 width=\"130\" border=\"0\" /><br />   <div>看张馨予的情挑绝活儿</div></a>         \n\r        </li>\n\r        <li>\n\r      <a href=\"http://www.exam8.com/school/tietu/201007/1455630.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201007/2010071615070768.jpg\" width=\"130\" border=\"0\" /><div>兽兽领衔靠艳照</div></a>\n\r        <a href=\"http://www.exam8.com/school/tietu/201007/1455595.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201007/2010071614471855.jpg\" width=\"130\" border=\"0\" />\n\r        <div>女星秀半球惹遐想</div>\n\r        </a>\n\r       </li>\n\r <li>      \n\r    <a href=\"http://www.exam8.com/school/tietu/201007/1447312.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/img/school/other/201007090108.jpg\" width=\"130\" border=\"0\"/>\n\r    <div>足球宝贝性感床照</div>\n\r    </a>   \n\r\n\r       <a href=\"http://www.exam8.com/school/tietu/201006/1336550.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201006/2010060309343361.jpg\" width=\"130\" border=\"0\" /><div>茹绮铃的士门不雅照</div></a>\n\r          </li>\n\r            \n\r    </ul>\n\r  </div>\n\r</div><script type=\"text/javascript\">myArticl.AuToPlay = true;myArticl.onload();</script><div class=\"tuhuamoer c049\"><a href=\"http://www.exam8.com/school/tietu/\" target=\"_blank\">更多>></a></div>\n\r</div></div>\n\r";
objAD.LinkUrl        = "";
objAD.LinkTarget     = 1;
objAD.LinkAlt        = "";
objAD.Priority       = 1;
objAD.CountView      = 0;
objAD.CountClick     = 0;
objAD.ADDIR          = "Exam8_AD";
ZoneAD_1151.AddAD(objAD);

ZoneAD_1151.Show();
