<?php



return [
    'unheardLike' => [

        'dialog' => [
            'askContinue' => '请输入 "." 继续',

            'cancel' => '游戏已经取消.',

            'missed' => '没有明白你的意思, AI侦探编号9527. 请严格按照程序提示执行训练任务. ',

            'matchFailed' => '不好意思, 你还没有正确匹配所有角色, 还不能回答问题.',

            'rewind' => '案件材料将从头开始播放',

            'noBackward' => '无法返回上一步, 可以重新开始',

            'youWin' => '恭喜你, 成功解开了谜团. ',

            'descScene' => "时间: {time}; 跟随: {follow}; 场景: {at};",

            'simpleDescScene' => "{follow}/{at}/{time}\n",

            'finishIntro' => '请先听我完成介绍',

            'confirmStart' => '请选择游戏是否开始',

            'restart' => '你已经获胜过, 游戏将重新开始.',

            'continuePlay' => '欢迎回来, 将继续上次的进度',

            'episodeDesc' => <<<EOF
标题: {title}

场景: {scenes}

角色: {roles}

身份: {names}
EOF
            ,

        ],

        'calling' => [

            'menu' => '你好, AI编号9527, 请选择你需要的操作.',

            'noTargetToFollow' => '当前并没有其他角色可以跟随',

            'chooseToFollow' => '挑选一位你将要跟随的对象.',

            'onlyChooseAvailable' => '只能就给出的选项作出选择.',

            'marked' => "你已标记情况如下 : \n{marked}",

            'chooseToMark' => '请选择要标记的角色',

            'chooseRoleToMark' => '你认为{marking}的身份是: ',

            'askSetTime' => '请用 "00:01" 的格式输入想跳转的时间点. ',

            'wrongType' => '不好意思, 输入格式不正确',
        ],


        'episode1' => [

            'intro' => [

                'demoDesc' => '这是一个两天开发完成的游戏 Demo, 复刻了 Steam 上非常优秀的声音游戏 "疑案追声" 的第一章, 用于展示: 
                
第一: "疑案追声" 这样优秀的声音游戏, 是可能与智能音箱高度结合的;
第二: 展现 CommuneChatbot 复杂多轮对话能力能提供哪种可能性.

您可以随时说"退出", 以退出游戏. 接下来游戏开始. ',

                'selfDesc' => '你好, AI侦探编号 9527, 我是你的 AI 训练师编号弥敦道九号, 昵称 "{c_calling}"',

                'purpose' => '你将通过一个个训练样本, 阅读案发现场相关对话的档案, 作出判断并经过我的修正, 逐步掌握推理案件真相的能力, 达到出厂标准.',

                'flow' => '在训练过程中, 你将阅读案情有关的材料. 每份材料都有若干个角色, 他们之间的对话包含了案情真相.',

                'missions' => '而你的任务有两个: 

第一, 你需要正确标注出每个角色在对话中的名字. 
第二, 你在阅读完材料后, 需要正确回答我提出的问题.',

                'calling' => <<<EOF
在测试中, 你将会 "{c_follow}" 某一个角色, 并且只能听取Ta周围的一切对话. 

而你也可以随时说 "{c_calling}" 唤醒我, 切换其他角色来 "{c_follow}", 从而获取更多隐藏讯息.

注意, 你只能追随所在空间里的其他角色, 不能追随任意一个角色.
EOF
                ,

                'commands' => '你也可以通过 "{c_calling}"唤醒我, 可以要求进行 "{c_mark}", 只有完成正确标注, 才能进入最终的回答. 
                
完成标注后, 也可以主动选择 "{c_answer}", 回答本章的问题. 更多命令请自行尝试.',

                'startCurrent' => '接下来就要正式进入我们本次的任务了.',

                'missionDesc' => '这是发生在某个派出所的一场审问, 你最终需要回答, "谁是藏毒案真正的犯人?"',

            ],


            'questions' => [
                'query1' => '那么, 请问谁是藏毒案真正的犯人呢?'
            ],

            'answers' => [
                'right' => '恭喜你, 答对了.',
                'wrong' => '不好意思, 你错了.',
            ],

            'win' => [
                'end' => '测试 demo 结束. ',
                'recommend' => '这是 疑案追声 试玩关卡的文字版. 游戏本体背景音乐加优秀的真人配音, 有非常优秀的沉浸感. 向您推荐该游戏.',
            ],

            'asides' => [
                '0059' => "说罢, {m_甲}离开了审讯室",
                '0100' => "{m_甲}缓步穿过走廊",
                '0113_1' => "{m_甲}敲响了接待间的门. 门打开了, 她走了进去.",
                '0113_2' => "接待室响起了敲门声, {m_丙}走过去打开门, {m_甲}走了进来",
                '0132' => "说罢, {m_甲}和{m_丙}推门离开了接待室",
                '0133' => "{m_甲}和{m_丙}缓步穿过走廊",
                '0138' => "{m_丁}拿出手机拨通了一个号码",
                '0141' => "{m_甲}和{m_丙}推门进入了审讯室.",
                '0304' => "{m_甲}和{m_丙}推门离开了审讯室.",
            ],

            'xu' => [
                '0000' => '{r_甲} : 姓名!',
                '0005' => '{r_甲} : 可是我看车主登记的名字... 是李伯文啊.',
                '0014' => '{r_甲} : 你和你哥倒是是挺像的啊',
                '0027' => '{r_甲} : 你这当弟弟的也不简单哪, 酒驾, 打人, 屡教不改啊.',
                '0042' => '{r_甲} : 除了酒驾, 还有什么要交待的?',
                '0050' => '{r_甲} : 你知道藏毒多少克判死刑吗?',
                '0057' => '{r_甲} : 行, 我问完了, 你在这里等着',
                '0116' => '{r_甲} : 老范',
                '0119' => '{r_甲} : 他说不知道, 还要说自己是李仲文',
                '0245' => '{r_甲} : 那... 等律师来了我们再继续?',
            ],

            'yi' => [
                '0001' => '{r_乙} : 我不是说过了嘛, 李仲文!',
                '0008' => '{r_乙} : 我偷偷开我哥的车, 出来兜兜风! 不行吗!?',
                '0016' => '{r_乙} : 哈, 连你也认识他啊, 不愧是网红CEO啊. 我俩是双胞胎, 自从他火了, 就经常有人把我看成是他',
                '0033' => '{r_乙} : 嗨, 都怪我那帮朋友, 我说了多少次不能喝不能喝. 唉, 下次不敢了',
                '0046' => '{r_乙} : 啊? 没有了啊?',
                '0052' => '{r_乙} : 啊..! 藏.藏毒? 谁.谁藏毒了啊? 我不知道啊',
                '0100' => '{r_乙} : 喂, 谁藏毒啦?! 喂, 你给我说清楚啊! 谁藏毒了! 喂, 你别走啊!',
                '0109' => '{r_乙} : (小声嘀咕) 咦..怎么回事啊.. 毒品, 毒品是什么意思啊?',
                '0117' => '{r_乙} : %B%在审讯室里坐着, 大惑不解地回想着',
                '0143' => '{r_乙} : 唉, 警察同志啊, 刚刚说的藏毒是怎么回事啊!',
                '0155' => '{r_乙} : 李~ ... 呃, 李仲文',
                '0206' => '{r_乙} : 啊? 他也来了啊',
                '0211' => '{r_乙} : 李.. 李伯文 (尴尬)',
                '0218' => '{r_乙} : 嗯..',
                '0225' => '{r_乙} : 不是, 这是... 到底... 到底是什么藏毒啊....',
                '0233' => '{r_乙} : 啊... 我不知道啊 ... 不行, 我要求见我律师!',

            ],

            'fan' => [
                '0005' => '{r_丙} : 来, 坐',
                '0009' => '{r_丙} : 你举报的线索都对, 人和物我们也都查到了. 可是有个事情我们想不明白, 你怎么会来举报亲哥哥呢?',
                '0027' => '{r_丙} : 嘿哟, 这怎么说啊?',
                '0040' => '{r_丙} : 那你为什么替他扛啊?',
                '0052' => '{r_丙} : 你这富二代想的倒是挺通透啊',
                '0100' => '{r_丙} : 那这次, 怎么不替他扛了啊?',
                '0117' => '{r_丙} : 小许, 你那边怎么样了',
                '0122' => '{r_丙} : 行了, 那就全对齐了, 你跟我去审讯室, 我去会会他',
                '0129' => '{r_丙} : 哎你在这等我一下啊, 等下要在举报材料上签个字',
                '0148' => '{r_丙} : 别急啊, 你先告诉我, 你叫什么名字',
                '0157' => '{r_丙} : 哼, 还想说谎啊. 你是李仲文, 那隔壁那个李仲文是怎么回事啊(严厉)?',
                '0208' => '{r_丙} : 我再问你一遍, 你是谁!',
                '0214' => '{r_丙} : 这不是第一次伪装成李仲文了吧. 这次要是酒驾, 也许就又被你糊弄过去了. 现在藏毒也想栽赃给你弟弟?!',
                '0230' => '{r_丙} : 在你后备箱里都搜出 XXX 毒品啦!',
                '0241' => '{r_丙} : 好嘞, 那你等着! 小许, 走吧.',
                '0248_1' => '{r_丙} : 哼, 律师? 现场人赃俱获, 执法记录仪都有视频.',
                '0248_2' => '{r_丙} : 再加上他这份笔录, 伪装身份, 对抗侦查, 性质恶劣, 移交法院足够说明问题了. 律师来了也是白搭! 走吧!',

            ],

            'wen' => [
                '0006' => '{r_丁} : 好的',
                '0022' => '{r_丁} : 哈, 我不害他, 他也要来害我啊!',
                '0030' => '{r_丁} : 因为是双胞胎啊, 从小到大, 每次出了事惹了祸, 他总是推到我头上. 现在他功成名就了, 我呢?',
                '0043' => '{r_丁} : 他是家族继承人啊! 我就是一个纨绔子弟, 偶尔酒驾, 打人, 扛就扛了, 无所谓啊.',
                '0055' => '{r_丁} : 哼, 不信你问他去, 现在肯定又伪装成李仲文啦~',
                '0104' => '{r_丁} : 这次? 这次是什么呀, 藏毒啊! 我有几个脑袋我也扛不了啊!',
                '0133' => '{r_丁} : 好嘞, 你去忙',
                '0139_1' => '{r_丁} : 喂, 我在警察局呢. 现在旁边没人, 我赶紧跟你说个事儿.',
                '0139_2' => '{r_丁} : 现在啊, 还差最后一步. 那个, 你去把卖货的那家伙给我封了口',
                '0139_3' => '{r_丁} : 对, 就是现在',
                '0155_1' => '{r_丁} : 废话! 警察也不是吃素的, xxx的货也不是小事, 下一步肯定要去追查货源',
                '0155_2' => '{r_丁} : 现在只有那卖货的能指证我, 所以, 赶紧的!!',
                '0208' => '{r_丁} : 嘿嘿, 刚刚我跟警察聊过了, 事情很顺利, 一点儿都没怀疑',
                '0217' => '{r_丁} : 我哥? 呵, 老样子, 这会儿正在隔壁演戏呢. 呵呵, 演呗, 演得越卖力越好',
                '0229' => '{r_丁} : 放心~ 我趁他喝醉的时候放进去的, 一点儿没察觉. 他先伪装身份, 欺骗警察, 再加上死活交待不出货源, 这次铁定交待进去啦',
                '0242_1' => '{r_丁} : 啧, 知道知道. 这次多亏了你了啊. 出了这个事情, 老爷子再偏心也护不住了.',
                '0242_2' => '{r_丁} : 嘿嘿, 等我成了继承人, 少不了你的好处',
                '0258' => '{r_丁} : 别高兴太早, 我跟你打电话不是闲扯淡的. 刚才跟你说的事情你给我上点心, 办好给我回个话, 挂了啊.',

            ],
        ]

    ],

];
