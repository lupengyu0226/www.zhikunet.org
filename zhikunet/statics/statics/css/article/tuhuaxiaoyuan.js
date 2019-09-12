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
objAD.ADName         = "����ҳ�ײ�ͼ��У԰";
objAD.ImgUrl         = "";
objAD.InstallDir     = "http://www.exam8.com/";
objAD.ImgWidth       = 0;
objAD.ImgHeight      = 0;
objAD.FlashWmode     = 0;
objAD.ADIntro        = "<div class=\"tuhua\"><div class=\"tuhuaxiaoyuan\"><a href=\"http://www.exam8.com/school/tietu/\" target=\"_blank\">ͼ��У԰</a></div><div class=\"sildPicBar\" id=\"sildPicBar\"><span class=\"pre\"></span><ul id=\"dot\"></ul><span class=\"next\"></span></div><div class=\"clear\"></div>\n\r<div class=\"wrap\">\n\r<div class=\"cntwrap\" id=\"cnt-wrap\">\n\r  <div class=\"cnt\" id=\"cnt\">\n\r    <ul>\n\r      <li>\n\r          <a href=\"http://www.exam8.com/school/tietu/201012/1725091.html\" target=\"_blank\"><img height=\"90\" src=\n\r  \"http://www.exam8.com/school/UploadFiles/201012/2010121616371702.jpg\" width=\"130\" border=\"0\" /><br />\n\r                <div>����ƾ���д���ع�</div></a>\n\r                  <a href=\"http://www.exam8.com/school/tietu/201012/1718730.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010121115261680.jpg\" width=\"130\" border=\"0\" /><br />\n\r              <div>�ź���ת����·��</div></a>\n\r              </li>\n\r              <li>\n\r           <a href=\"http://www.exam8.com/school/tietu/201012/1718430.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010121019040337.jpg\" width=\"130\" border=\"0\" /><br />\n\r              <div>����漾����´����ﻷ��</div></a> \n\r                <a href=\"http://www.exam8.com/school/tietu/201012/1718427.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010122617384210.jpg\"\n\r				 width=\"130\" border=\"0\" /><br />   <div>������д����������</div></a></li>\n\r                <li>\n\r                 \n\r <a href=\"http://www.exam8.com/school/tietu/201012/1718468.html\" target=\"_blank\"><img height=\"90\" src=\n\r  \"http://www.exam8.com/school/UploadFiles/201012/2010121019523682.jpg\"\n\r   width=\"130\" border=\"0\" /><br />\n\r                <div>��ʫӢ���ݻ����ԸС�</div></a>    \n\r         \n\r            \n\r        <a href=\"http://www.exam8.com/school/tietu/201012/1718642.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010121111454631.jpg\" width=\"130\" border=\"0\" /><br />\n\r              <div>���������ޡ����ﳿд��</div></a>\n\r               \n\r        \n\r              </li>\n\r              <li>\n\r                <a href=\"http://www.exam8.com/school/tietu/201012/1718636.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010121111322201.jpg\" width=\"130\" border=\"0\" /><br />\n\r              <div>��������д��OL��ʮ��</div></a>         \n\r            <a href=\"http://www.exam8.com/school/tietu/201012/1725248.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010121617275482.jpg\" width=\"130\" border=\"0\" /><br /><div>���ҳ��ջ�д���ع�</div></a>\n\r            </li>\n\r            <li>\n\r              <a href=\"http://www.exam8.com/school/tietu/201012/1717207.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201012/2010120916485736.jpg\" width=\"130\" border=\"0\" /><div>�����޷��ֵ��������ջ�</div></a>  \n\r     <a href=\"http://www.exam8.com/school/tietu/201007/1456463.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201007/2010071610462451.jpg\" width=\"130\" border=\"0\" /><br /><div>��һ����Ů��ʯԭ����</div></a>  \n\r     </li>\n\r\n\r    <li>\n\r      <a href=\"http://www.exam8.com/school/tietu/201007/1459480.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201007/2010071910182993.jpg\" width=\"130\" border=\"0\" /><div>�Ű�֥�����ʱ����־</div></a>\n\r   <a href=\"http://www.exam8.com/school/tietu/201007/1456458.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201007/2010071610375988.jpg\"\n\r				 width=\"130\" border=\"0\" /><br />   <div>����ܰ������������</div></a>         \n\r        </li>\n\r        <li>\n\r      <a href=\"http://www.exam8.com/school/tietu/201007/1455630.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201007/2010071615070768.jpg\" width=\"130\" border=\"0\" /><div>�������ο�����</div></a>\n\r        <a href=\"http://www.exam8.com/school/tietu/201007/1455595.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201007/2010071614471855.jpg\" width=\"130\" border=\"0\" />\n\r        <div>Ů�������������</div>\n\r        </a>\n\r       </li>\n\r <li>      \n\r    <a href=\"http://www.exam8.com/school/tietu/201007/1447312.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/img/school/other/201007090108.jpg\" width=\"130\" border=\"0\"/>\n\r    <div>���򱦱��Ըд���</div>\n\r    </a>   \n\r\n\r       <a href=\"http://www.exam8.com/school/tietu/201006/1336550.html\" target=\"_blank\"><img height=\"90\" src=\"http://www.exam8.com/school/UploadFiles/201006/2010060309343361.jpg\" width=\"130\" border=\"0\" /><div>������ʿ�Ų�����</div></a>\n\r          </li>\n\r            \n\r    </ul>\n\r  </div>\n\r</div><script type=\"text/javascript\">myArticl.AuToPlay = true;myArticl.onload();</script><div class=\"tuhuamoer c049\"><a href=\"http://www.exam8.com/school/tietu/\" target=\"_blank\">����>></a></div>\n\r</div></div>\n\r";
objAD.LinkUrl        = "";
objAD.LinkTarget     = 1;
objAD.LinkAlt        = "";
objAD.Priority       = 1;
objAD.CountView      = 0;
objAD.CountClick     = 0;
objAD.ADDIR          = "Exam8_AD";
ZoneAD_1151.AddAD(objAD);

ZoneAD_1151.Show();
