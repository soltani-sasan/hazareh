import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';
import '../widgets/common.dart';

class ConferenceScreen extends StatefulWidget {
  const ConferenceScreen({super.key});
  @override
  State<ConferenceScreen> createState() => _ConferenceScreenState();
}

class _ConferenceScreenState extends State<ConferenceScreen> {
  Map? _conf;
  bool _loading = true;

  @override
  void initState() { super.initState(); _load(); }

  Future<void> _load() async {
    try {
      final d = await ApiService.getConference();
      if (mounted) setState(() { _conf = d['data']; _loading = false; });
    } catch(_) {
      if (mounted) setState(() => _loading = false);
    }
  }

  @override
  Widget build(BuildContext context) => Scaffold(
    body: _loading ? const LoadingState() :
    CustomScrollView(slivers:[
      SliverAppBar(
        expandedHeight:200, pinned:true,
        backgroundColor:AppColors.primaryDark,
        flexibleSpace:FlexibleSpaceBar(
          background:Container(
            decoration:const BoxDecoration(gradient:LinearGradient(
              colors:[AppColors.primaryDark, Color(0xFF1E40AF)],
              begin:Alignment.topRight, end:Alignment.bottomLeft)),
            child:Center(child:Column(mainAxisAlignment:MainAxisAlignment.center,
              children:[
                const SizedBox(height:40),
                const Icon(Icons.emoji_events, size:48, color:Color(0xFFF59E0B)),
                const SizedBox(height:10),
                const Text('همایش بین‌المللی',
                    style:TextStyle(fontSize:18,fontWeight:FontWeight.bold,color:Colors.white)),
                const SizedBox(height:4),
                const Text('هنرستان‌های جوار صنعت',
                    style:TextStyle(fontSize:13,color:Colors.white70)),
              ])),
          ),
        ),
      ),

      SliverPadding(
        padding:const EdgeInsets.all(16),
        sliver:SliverList(delegate:SliverChildListDelegate([

          if (_conf != null) ...[
            Card(child:Padding(padding:const EdgeInsets.all(16), child:Column(
              crossAxisAlignment:CrossAxisAlignment.start, children:[
                const Text('اطلاعات همایش',
                    style:TextStyle(fontSize:16,fontWeight:FontWeight.bold,
                        color:AppColors.primary)),
                const SizedBox(height:12),
                InfoTile(icon:Icons.title, label:'عنوان',
                    value:_conf!['title']??''),
                if(_conf!['start_date']!=null)
                  InfoTile(icon:Icons.calendar_today_outlined, label:'تاریخ',
                      value:'${_conf!["start_date"]} تا ${_conf!["end_date"]}'),
                InfoTile(icon:Icons.location_on_outlined, label:'محل',
                    value:_conf!['venue']??''),
                if(_conf!['submission_deadline']!=null)
                  InfoTile(icon:Icons.timer_outlined, label:'مهلت ارسال',
                      value:_conf!['submission_deadline'].toString()),
              ])),
            ),
            const SizedBox(height:16),
          ],

          const Text('محورهای همایش',
              style:TextStyle(fontSize:16,fontWeight:FontWeight.bold,color:AppColors.primary)),
          const SizedBox(height:12),

          ...[
            {'icon':Icons.settings,'color':const Color(0xFF1A3A5C),
              'title':'تعمیر و نگهداری ابزار دقیق',
              'sub':'فناوری‌های نوین، اتوماسیون، نگهداری پیشگیرانه'},
            {'icon':Icons.plumbing,'color':const Color(0xFF059669),
              'title':'تاسیسات مکانیکی',
              'sub':'طراحی، بهینه‌سازی، ارزیابی'},
            {'icon':Icons.bolt,'color':const Color(0xFFD97706),
              'title':'برق صنعتی',
              'sub':'انرژی تجدیدپذیر، توزیع، اینترنت اشیا'},
            {'icon':Icons.lightbulb_outline,'color':const Color(0xFF7C3AED),
              'title':'نوآوری و ایده‌های جدید',
              'sub':'ایده‌پردازی هنرجویان، پروژه‌های کارآفرینی'},
          ].map((t) => Card(
            margin:const EdgeInsets.only(bottom:10),
            child:ListTile(
              leading:CircleAvatar(backgroundColor:(t['color']as Color).withOpacity(0.12),
                  child:Icon(t['icon'] as IconData, color:t['color'] as Color, size:22)),
              title:Text(t['title'] as String,
                  style:const TextStyle(fontWeight:FontWeight.bold,fontSize:14)),
              subtitle:Text(t['sub'] as String,style:const TextStyle(fontSize:12)),
            ),
          )).toList(),

          const SizedBox(height:16),
          PrimaryButton(
            label: 'ثبت‌نام در همایش',
            onPressed: () => _registerDialog(context),
          ),
          const SizedBox(height:24),
        ])),
      ),
    ]),
  );

  void _registerDialog(BuildContext ctx) {
    final nameCtrl = TextEditingController();
    final emailCtrl = TextEditingController();
    final phoneCtrl = TextEditingController();
    String type = 'public';

    showDialog(context:ctx, builder:(_)=>StatefulBuilder(
      builder:(c,ss)=>AlertDialog(
        title:const Text('ثبت‌نام در همایش'),
        content:SingleChildScrollView(child:Column(mainAxisSize:MainAxisSize.min,children:[
          TextField(controller:nameCtrl,
              decoration:const InputDecoration(labelText:'نام و نام خانوادگی *')),
          const SizedBox(height:10),
          TextField(controller:emailCtrl, keyboardType:TextInputType.emailAddress,
              decoration:const InputDecoration(labelText:'ایمیل *')),
          const SizedBox(height:10),
          TextField(controller:phoneCtrl, keyboardType:TextInputType.phone,
              decoration:const InputDecoration(labelText:'موبایل *')),
          const SizedBox(height:10),
          DropdownButtonFormField<String>(value:type,
            decoration:const InputDecoration(labelText:'نوع شرکت‌کننده'),
            onChanged:(v)=>ss(()=>type=v!),
            items:const [
              DropdownMenuItem(value:'public',child:Text('عموم مردم')),
              DropdownMenuItem(value:'student',child:Text('هنرجو')),
              DropdownMenuItem(value:'teacher',child:Text('دبیر/هنرآموز')),
              DropdownMenuItem(value:'industry',child:Text('کارکنان صنعت')),
            ],
          ),
        ])),
        actions:[
          TextButton(onPressed:()=>Navigator.pop(c), child:const Text('انصراف')),
          ElevatedButton(onPressed:() async {
            Navigator.pop(c);
            try {
              await ApiService.registerConference({
                'full_name':nameCtrl.text,'email':emailCtrl.text,
                'phone':phoneCtrl.text,'participant_type':type,
              });
              if(ctx.mounted) ScaffoldMessenger.of(ctx).showSnackBar(
                const SnackBar(content:Text('ثبت‌نام شما با موفقیت انجام شد'),
                    backgroundColor:Colors.green));
            } catch(_) {
              if(ctx.mounted) ScaffoldMessenger.of(ctx).showSnackBar(
                const SnackBar(content:Text('خطا در ثبت‌نام'),
                    backgroundColor:Colors.red));
            }
          }, child:const Text('ثبت‌نام')),
        ],
      ),
    ));
  }
}
