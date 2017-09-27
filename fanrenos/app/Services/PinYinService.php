<?php
namespace App\Services;

/**
* 汉字拼音类
* 参考http://blog.csdn.net/daxia_85/article/details/53262117
*/
class PinYinService
{
    static $data = [
        array('a',-20319),array('ai',-20317),array('an',-20304),array('ang',-20295),array('ao',-20292),array('ba',-20283),
        array('bai',-20265),array('ban',-20257),array('bang',-20242),array('bao',-20230),array('bei',-20051),array('ben',-20036),
        array('beng',-20032),array('bi',-20026),array('bian',-20002),array('biao',-19990),array('bie',-19986),array('bin',-19982),
        array('bing',-19976),array('bo',-19805),array('bu',-19784),array('ca',-19775),array('cai',-19774),array('can',-19763),
        array('cang',-19756),array('cao',-19751),array('ce',-19746),array('ceng',-19741),array('cha',-19739),array('chai',-19728),
        array('chan',-19725),array('chang',-19715),array('chao',-19540),array('che',-19531),array('chen',-19525),array('cheng',-19515),
        array('chi',-19500),array('chong',-19484),array('chou',-19479),array('chu',-19467),array('chuai',-19289),array('chuan',-19288),
        array('chuang',-19281),array('chui',-19275),array('chun',-19270),array('chuo',-19263),array('ci',-19261),array('cong',-19249),
        array('cou',-19243),array('cu',-19242),array('cuan',-19238),array('cui',-19235),array('cun',-19227),array('cuo',-19224),
        array('da',-19218),array('dai',-19212),array('dan',-19038),array('dang',-19023),array('dao',-19018),array('de',-19006),
        array('deng',-19003),array('di',-18996),array('dian',-18977),array('diao',-18961),array('die',-18952),array('ding',-18783),
        array('diu',-18774),array('dong',-18773),array('dou',-18763),array('du',-18756),array('duan',-18741),array('dui',-18735),
        array('dun',-18731),array('duo',-18722),array('e',-18710),array('en',-18697),array('er',-18696),array('fa',-18526),
        array('fan',-18518),array('fang',-18501),array('fei',-18490),array('fen',-18478),array('feng',-18463),array('fo',-18448),
        array('fou',-18447),array('fu',-18446),array('ga',-18239),array('gai',-18237),array('gan',-18231),array('gang',-18220),
        array('gao',-18211),array('ge',-18201),array('gei',-18184),array('gen',-18183),array('geng',-18181),array('gong',-18012),
        array('gou',-17997),array('gu',-17988),array('gua',-17970),array('guai',-17964),array('guan',-17961),array('guang',-17950),
        array('gui',-17947),array('gun',-17931),array('guo',-17928),array('ha',-17922),array('hai',-17759),array('han',-17752),
        array('hang',-17733),array('hao',-17730),array('he',-17721),array('hei',-17703),array('hen',-17701),array('heng',-17697),
        array('hong',-17692),array('hou',-17683),array('hu',-17676),array('hua',-17496),array('huai',-17487),array('huan',-17482),
        array('huang',-17468),array('hui',-17454),array('hun',-17433),array('huo',-17427),array('ji',-17417),array('jia',-17202),
        array('jian',-17185),array('jiang',-16983),array('jiao',-16970),array('jie',-16942),array('jin',-16915),array('jing',-16733),
        array('jiong',-16708),array('jiu',-16706),array('ju',-16689),array('juan',-16664),array('jue',-16657),array('jun',-16647),
        array('ka',-16474),array('kai',-16470),array('kan',-16465),array('kang',-16459),array('kao',-16452),array('ke',-16448),
        array('ken',-16433),array('keng',-16429),array('kong',-16427),array('kou',-16423),array('ku',-16419),array('kua',-16412),
        array('kuai',-16407),array('kuan',-16403),array('kuang',-16401),array('kui',-16393),array('kun',-16220),array('kuo',-16216),
        array('la',-16212),array('lai',-16205),array('lan',-16202),array('lang',-16187),array('lao',-16180),array('le',-16171),
        array('lei',-16169),array('leng',-16158),array('li',-16155),array('lia',-15959),array('lian',-15958),array('liang',-15944),
        array('liao',-15933),array('lie',-15920),array('lin',-15915),array('ling',-15903),array('liu',-15889),array('long',-15878),
        array('lou',-15707),array('lu',-15701),array('lv',-15681),array('luan',-15667),array('lue',-15661),array('lun',-15659),
        array('luo',-15652),array('ma',-15640),array('mai',-15631),array('man',-15625),array('mang',-15454),array('mao',-15448),
        array('me',-15436),array('mei',-15435),array('men',-15419),array('meng',-15416),array('mi',-15408),array('mian',-15394),
        array('miao',-15385),array('mie',-15377),array('min',-15375),array('ming',-15369),array('miu',-15363),array('mo',-15362),
        array('mou',-15183),array('mu',-15180),array('na',-15165),array('nai',-15158),array('nan',-15153),array('nang',-15150),
        array('nao',-15149),array('ne',-15144),array('nei',-15143),array('nen',-15141),array('neng',-15140),array('ni',-15139),
        array('nian',-15128),array('niang',-15121),array('niao',-15119),array('nie',-15117),array('nin',-15110),array('ning',-15109),
        array('niu',-14941),array('nong',-14937),array('nu',-14933),array('nv',-14930),array('nuan',-14929),array('nue',-14928),
        array('nuo',-14926),array('o',-14922),array('ou',-14921),array('pa',-14914),array('pai',-14908),array('pan',-14902),
        array('pang',-14894),array('pao',-14889),array('pei',-14882),array('pen',-14873),array('peng',-14871),array('pi',-14857),
        array('pian',-14678),array('piao',-14674),array('pie',-14670),array('pin',-14668),array('ping',-14663),array('po',-14654),
        array('pu',-14645),array('qi',-14630),array('qia',-14594),array('qian',-14429),array('qiang',-14407),array('qiao',-14399),
        array('qie',-14384),array('qin',-14379),array('qing',-14368),array('qiong',-14355),array('qiu',-14353),array('qu',-14345),
        array('quan',-14170),array('que',-14159),array('qun',-14151),array('ran',-14149),array('rang',-14145),array('rao',-14140),
        array('re',-14137),array('ren',-14135),array('reng',-14125),array('ri',-14123),array('rong',-14122),array('rou',-14112),
        array('ru',-14109),array('ruan',-14099),array('rui',-14097),array('run',-14094),array('ruo',-14092),array('sa',-14090),
        array('sai',-14087),array('san',-14083),array('sang',-13917),array('sao',-13914),array('se',-13910),array('sen',-13907),
        array('seng',-13906),array('sha',-13905),array('shai',-13896),array('shan',-13894),array('shang',-13878),array('shao',-13870),
        array('she',-13859),array('shen',-13847),array('sheng',-13831),array('shi',-13658),array('shou',-13611),array('shu',-13601),
        array('shua',-13406),array('shuai',-13404),array('shuan',-13400),array('shuang',-13398),array('shui',-13395),
        array('shun',-13391),array('shuo',-13387),array('si',-13383),array('song',-13367),array('sou',-13359),array('su',-13356),
        array('suan',-13343),array('sui',-13340),array('sun',-13329),array('suo',-13326),array('ta',-13318),array('tai',-13147),
        array('tan',-13138),array('tang',-13120),array('tao',-13107),array('te',-13096),array('teng',-13095),array('ti',-13091),
        array('tian',-13076),array('tiao',-13068),array('tie',-13063),array('ting',-13060),array('tong',-12888),array('tou',-12875),
        array('tu',-12871),array('tuan',-12860),array('tui',-12858),array('tun',-12852),array('tuo',-12849),array('wa',-12838),
        array('wai',-12831),array('wan',-12829),array('wang',-12812),array('wei',-12802),array('wen',-12607),array('weng',-12597),
        array('wo',-12594),array('wu',-12585),array('xi',-12556),array('xia',-12359),array('xian',-12346),array('xiang',-12320),
        array('xiao',-12300),array('xie',-12120),array('xin',-12099),array('xing',-12089),array('xiong',-12074),array('xiu',-12067),
        array('xu',-12058),array('xuan',-12039),array('xue',-11867),array('xun',-11861),array('ya',-11847),array('yan',-11831),
        array('yang',-11798),array('yao',-11781),array('ye',-11604),array('yi',-11589),array('yin',-11536),array('ying',-11358),
        array('yo',-11340),array('yong',-11339),array('you',-11324),array('yu',-11303),array('yuan',-11097),array('yue',-11077),
        array('yun',-11067),array('za',-11055),array('zai',-11052),array('zan',-11045),array('zang',-11041),array('zao',-11038),
        array('ze',-11024),array('zei',-11020),array('zen',-11019),array('zeng',-11018),array('zha',-11014),array('zhai',-10838),
        array('zhan',-10832),array('zhang',-10815),array('zhao',-10800),array('zhe',-10790),array('zhen',-10780),array('zheng',-10764),
        array('zhi',-10587),array('zhong',-10544),array('zhou',-10533),array('zhu',-10519),array('zhua',-10331),array('zhuai',-10329),
        array('zhuan',-10328),array('zhuang',-10322),array('zhui',-10315),array('zhun',-10309),array('zhuo',-10307),array('zi',-10296),
        array('zong',-10281),array('zou',-10274),array('zu',-10270),array('zuan',-10262),array('zui',-10260),array('zun',-10256),
        array('zuo',-10254)
    ];
    //常用简体
    private static $sd="皑蔼碍爱翱袄奥坝罢摆败颁办绊帮绑镑谤剥饱宝报鲍辈贝钡狈备惫绷笔毕毙币闭边编贬变辩辫标鳖别瘪濒滨宾摈饼并拨钵铂驳卜补财参蚕残惭惨灿苍舱仓沧厕侧册测层诧搀掺蝉馋谗缠铲产阐颤场尝长偿肠厂畅钞车彻尘沉陈衬撑称惩诚骋痴迟驰耻齿炽冲虫宠畴踌筹绸丑橱厨锄雏础储触处传疮闯创锤纯绰辞词赐聪葱囱从丛凑蹿窜错达带贷担单郸掸胆惮诞弹当挡党荡档捣岛祷导盗灯邓敌涤递缔颠点垫电淀钓调迭谍叠钉顶锭订丢东动栋冻斗犊独读赌镀锻断缎兑队对吨顿钝夺堕鹅额讹恶饿儿尔饵贰发罚阀珐矾钒烦范贩饭访纺飞诽废费纷坟奋愤粪丰枫锋风疯冯缝讽凤肤辐抚辅赋复负讣妇缚该钙盖干赶秆赣冈刚钢纲岗皋镐搁鸽阁铬个给龚宫巩贡钩沟构购够蛊顾剐关观馆惯贯广规硅归龟闺轨诡柜贵刽辊滚锅国过骇韩汉号阂鹤贺横轰鸿红后壶护沪户哗华画划话怀坏欢环还缓换唤痪焕涣黄谎挥辉毁贿秽会烩汇讳诲绘荤浑伙获货祸击机积饥讥鸡绩缉极辑级挤几蓟剂济计记际继纪夹荚颊贾钾价驾歼监坚笺间艰缄茧检碱硷拣捡简俭减荐槛鉴践贱见键舰剑饯渐溅涧将浆蒋桨奖讲酱胶浇骄娇搅铰矫侥脚饺缴绞轿较秸阶节茎鲸惊经颈静镜径痉竞净纠厩旧驹举据锯惧剧鹃绢杰洁结诫届紧锦仅谨进晋烬尽劲荆觉决诀绝钧军骏开凯颗壳课垦恳抠库裤夸块侩宽矿旷况亏岿窥馈溃扩阔蜡腊莱来赖蓝栏拦篮阑兰澜谰揽览懒缆烂滥捞劳涝乐镭垒类泪篱离里鲤礼丽厉励砾历沥隶俩联莲连镰怜涟帘敛脸链恋炼练粮凉两辆谅疗辽镣猎临邻鳞凛赁龄铃凌灵岭领馏刘龙聋咙笼垄拢陇楼娄搂篓芦卢颅庐炉掳卤虏鲁赂禄录陆驴吕铝侣屡缕虑滤绿峦挛孪滦乱抡轮伦仑沦纶论萝罗逻锣箩骡骆络妈玛码蚂马骂吗买麦卖迈脉瞒馒蛮满谩猫锚铆贸么霉没镁门闷们锰梦谜弥觅幂绵缅庙灭悯闽鸣铭谬谋亩钠纳难挠脑恼闹馁内拟腻撵捻酿鸟聂啮镊镍柠狞宁拧泞钮纽脓浓农疟诺欧鸥殴呕沤盘庞赔喷鹏骗飘频贫苹凭评泼颇扑铺朴谱栖凄脐齐骑岂启气弃讫牵扦钎铅迁签谦钱钳潜浅谴堑枪呛墙蔷强抢锹桥乔侨翘窍窃钦亲寝轻氢倾顷请庆琼穷趋区躯驱龋颧权劝却鹊确让饶扰绕热韧认纫荣绒软锐闰润洒萨鳃赛叁伞丧骚扫涩杀纱筛晒删闪陕赡缮伤赏烧绍赊摄慑设绅审婶肾渗声绳胜圣师狮湿诗尸时蚀实识驶势适释饰视试寿兽枢输书赎属术树竖数帅双谁税顺说硕烁丝饲耸怂颂讼诵擞苏诉肃虽随绥岁孙损笋缩琐锁獭挞抬态摊贪瘫滩坛谭谈叹汤烫涛绦讨腾誊锑题体屉条贴铁厅听烃铜统头秃图涂团颓蜕脱鸵驮驼椭洼袜弯湾顽万网韦违围为潍维苇伟伪纬谓卫温闻纹稳问瓮挝蜗涡窝卧呜钨乌污诬无芜吴坞雾务误锡牺袭习铣戏细虾辖峡侠狭厦吓锨鲜纤咸贤衔闲显险现献县馅羡宪线厢镶乡详响项萧嚣销晓啸蝎协挟携胁谐写泻谢锌衅兴汹锈绣虚嘘须许叙绪续轩悬选癣绚学勋询寻驯训讯逊压鸦鸭哑亚讶阉烟盐严颜阎艳厌砚彦谚验鸯杨扬疡阳痒养样瑶摇尧遥窑谣药爷页业叶医铱颐遗仪彝蚁艺亿忆义诣议谊译异绎荫阴银饮隐樱婴鹰应缨莹萤营荧蝇赢颖哟拥佣痈踊咏涌优忧邮铀犹游诱舆鱼渔娱与屿语吁御狱誉预驭鸳渊辕园员圆缘远愿约跃钥岳粤悦阅云郧匀陨运蕴酝晕韵杂灾载攒暂赞赃脏凿枣灶责择则泽贼赠扎札轧铡闸栅诈斋债毡盏斩辗崭栈战绽张涨帐账胀赵蛰辙锗这贞针侦诊镇阵挣睁狰争帧郑证织职执纸挚掷帜质滞钟终种肿众诌轴皱昼骤猪诸诛烛瞩嘱贮铸筑驻专砖转赚桩庄装妆壮状锥赘坠缀谆着浊兹资渍踪综总纵邹诅组钻";
    //常用繁体
    private static $td="皚藹礙愛翺襖奧壩罷擺敗頒辦絆幫綁鎊謗剝飽寶報鮑輩貝鋇狽備憊繃筆畢斃幣閉邊編貶變辯辮標鼈別癟瀕濱賓擯餅並撥缽鉑駁蔔補財參蠶殘慚慘燦蒼艙倉滄廁側冊測層詫攙摻蟬饞讒纏鏟産闡顫場嘗長償腸廠暢鈔車徹塵沈陳襯撐稱懲誠騁癡遲馳恥齒熾沖蟲寵疇躊籌綢醜櫥廚鋤雛礎儲觸處傳瘡闖創錘純綽辭詞賜聰蔥囪從叢湊躥竄錯達帶貸擔單鄲撣膽憚誕彈當擋黨蕩檔搗島禱導盜燈鄧敵滌遞締顛點墊電澱釣調叠諜疊釘頂錠訂丟東動棟凍鬥犢獨讀賭鍍鍛斷緞兌隊對噸頓鈍奪墮鵝額訛惡餓兒爾餌貳發罰閥琺礬釩煩範販飯訪紡飛誹廢費紛墳奮憤糞豐楓鋒風瘋馮縫諷鳳膚輻撫輔賦複負訃婦縛該鈣蓋幹趕稈贛岡剛鋼綱崗臯鎬擱鴿閣鉻個給龔宮鞏貢鈎溝構購夠蠱顧剮關觀館慣貫廣規矽歸龜閨軌詭櫃貴劊輥滾鍋國過駭韓漢號閡鶴賀橫轟鴻紅後壺護滬戶嘩華畫劃話懷壞歡環還緩換喚瘓煥渙黃謊揮輝毀賄穢會燴彙諱誨繪葷渾夥獲貨禍擊機積饑譏雞績緝極輯級擠幾薊劑濟計記際繼紀夾莢頰賈鉀價駕殲監堅箋間艱緘繭檢堿鹼揀撿簡儉減薦檻鑒踐賤見鍵艦劍餞漸濺澗將漿蔣槳獎講醬膠澆驕嬌攪鉸矯僥腳餃繳絞轎較稭階節莖鯨驚經頸靜鏡徑痙競淨糾廄舊駒舉據鋸懼劇鵑絹傑潔結誡屆緊錦僅謹進晉燼盡勁荊覺決訣絕鈞軍駿開凱顆殼課墾懇摳庫褲誇塊儈寬礦曠況虧巋窺饋潰擴闊蠟臘萊來賴藍欄攔籃闌蘭瀾讕攬覽懶纜爛濫撈勞澇樂鐳壘類淚籬離裏鯉禮麗厲勵礫曆瀝隸倆聯蓮連鐮憐漣簾斂臉鏈戀煉練糧涼兩輛諒療遼鐐獵臨鄰鱗凜賃齡鈴淩靈嶺領餾劉龍聾嚨籠壟攏隴樓婁摟簍蘆盧顱廬爐擄鹵虜魯賂祿錄陸驢呂鋁侶屢縷慮濾綠巒攣孿灤亂掄輪倫侖淪綸論蘿羅邏鑼籮騾駱絡媽瑪碼螞馬罵嗎買麥賣邁脈瞞饅蠻滿謾貓錨鉚貿麽黴沒鎂門悶們錳夢謎彌覓冪綿緬廟滅憫閩鳴銘謬謀畝鈉納難撓腦惱鬧餒內擬膩攆撚釀鳥聶齧鑷鎳檸獰甯擰濘鈕紐膿濃農瘧諾歐鷗毆嘔漚盤龐賠噴鵬騙飄頻貧蘋憑評潑頗撲鋪樸譜棲淒臍齊騎豈啓氣棄訖牽扡釺鉛遷簽謙錢鉗潛淺譴塹槍嗆牆薔強搶鍬橋喬僑翹竅竊欽親寢輕氫傾頃請慶瓊窮趨區軀驅齲顴權勸卻鵲確讓饒擾繞熱韌認紉榮絨軟銳閏潤灑薩鰓賽三傘喪騷掃澀殺紗篩曬刪閃陝贍繕傷賞燒紹賒攝懾設紳審嬸腎滲聲繩勝聖師獅濕詩屍時蝕實識駛勢適釋飾視試壽獸樞輸書贖屬術樹豎數帥雙誰稅順說碩爍絲飼聳慫頌訟誦擻蘇訴肅雖隨綏歲孫損筍縮瑣鎖獺撻擡態攤貪癱灘壇譚談歎湯燙濤縧討騰謄銻題體屜條貼鐵廳聽烴銅統頭禿圖塗團頹蛻脫鴕馱駝橢窪襪彎灣頑萬網韋違圍爲濰維葦偉僞緯謂衛溫聞紋穩問甕撾蝸渦窩臥嗚鎢烏汙誣無蕪吳塢霧務誤錫犧襲習銑戲細蝦轄峽俠狹廈嚇鍁鮮纖鹹賢銜閑顯險現獻縣餡羨憲線廂鑲鄉詳響項蕭囂銷曉嘯蠍協挾攜脅諧寫瀉謝鋅釁興洶鏽繡虛噓須許敘緒續軒懸選癬絢學勳詢尋馴訓訊遜壓鴉鴨啞亞訝閹煙鹽嚴顔閻豔厭硯彥諺驗鴦楊揚瘍陽癢養樣瑤搖堯遙窯謠藥爺頁業葉醫銥頤遺儀彜蟻藝億憶義詣議誼譯異繹蔭陰銀飲隱櫻嬰鷹應纓瑩螢營熒蠅贏穎喲擁傭癰踴詠湧優憂郵鈾猶遊誘輿魚漁娛與嶼語籲禦獄譽預馭鴛淵轅園員圓緣遠願約躍鑰嶽粵悅閱雲鄖勻隕運蘊醞暈韻雜災載攢暫贊贓髒鑿棗竈責擇則澤賊贈紮劄軋鍘閘柵詐齋債氈盞斬輾嶄棧戰綻張漲帳賬脹趙蟄轍鍺這貞針偵診鎮陣掙睜猙爭幀鄭證織職執紙摯擲幟質滯鍾終種腫衆謅軸皺晝驟豬諸誅燭矚囑貯鑄築駐專磚轉賺樁莊裝妝壯狀錐贅墜綴諄著濁茲資漬蹤綜總縱鄒詛組鑽";
    /**
     * 获取汉字转化拼音
     * 繁体字转拼音会出错，需要将繁体转换为简体后，再执行拼音转换操作
     */ 
    public static function get($str, $charset = 'gbk', $first = 0)
    {
        $str = trim($str);

        if ($charset != 'gbk' && $charset != 'gb2312') $str = iconv($charset, 'gbk', $str);

        $ret = '';

        $prev_zhi = '';
        for($i = 0; $i < strlen($str); $i++) {
            if($i>0){
                $prev_zhi = substr($str, $i-1, 1);
            }
            $zh_zhi = substr($str, $i, 1);
            //如果此字符不是中文，则跳过此次循环
            if(!preg_match("/^[\x7f-\xff]+$/", $zh_zhi)){
                //此处判断是为了保证像这种情况的字符串能够正常转换成功
                //即：string中文string => string zhong wen string
                //如果不加此判断，最终会变为：string zhong wenstring
                if(preg_match("/^[\x7f-\xff]+$/", $prev_zhi)){
                    $ret .= ' '.$zh_zhi;
                }else{
                    $ret .= $zh_zhi;
                }
               continue;
            }
            $p = ord($zh_zhi);//将ASCLL码值转换为字符

            if($p > 160) {
                $q = ord(substr($str, ++$i, 1));
                $p = $p*256 + $q - 65536;
            }

            $zhi = self::chr($p);

            if($first) $zhi = substr($zhi, 0, 1);

            $ret .= ' '.$zhi;
        }

        return $ret;
    }

    /**
     * 获取汉字对应的首字母
     */
    public static function initial($str, $charset = 'gbk', $first = 0)
    {
        $str = strtolower(self::get($str, $charset, $first));

        return $first ? $str : substr($str, 0, 1);
    }

    private static function chr($num)
    {
        if ($num > 0 && $num < 160) {
            return chr($num);
        } else if ($num < -20319 || $num > -10247) {
            return '';
        } else {
            for ($i = count(self::$data)-1; $i >= 0; $i--) {
                if(self::$data[$i][1] <= $num) break;
            }

            return self::$data[$i][0];
        }
    }

    /**
     * 繁体转化简体
     *
     * @param string $sContent 要转化的字符串
     * @return string 转化之后得到的字符串
     */ 
    public static function tradition2simple($sContent)
    {
        $simpleCN = '';
        $iContent=mb_strlen($sContent,'UTF-8');

        for($i=0;$i<$iContent;$i++){
            $str=mb_substr($sContent,$i,1,'UTF-8');
            $match=mb_strpos(self::$td,$str,null,'UTF-8');
            $simpleCN.=($match!==false )?mb_substr(self::$sd,$match,1,'UTF-8'):$str;
        }

        return $simpleCN;
    }

    /**
     * 简体转化繁体
     * 
     * @param string $sContent 要转化的字符串
     * @return string 转化之后得到的字符串
     */
    public static function simple2tradition($sContent)
    {
        $traditionalCN = '';
        $iContent=mb_strlen($sContent,'UTF-8');

        for($i=0;$i<$iContent;$i++){
            $str=mb_substr($sContent,$i,1,'UTF-8');
            $match=mb_strpos(self::$sd,$str,null,'UTF-8');
            $traditionalCN.=($match!==false )?mb_substr(self::$td,$match,1,'UTF-8'):$str;
        }

            return $traditionalCN;
    } 
}