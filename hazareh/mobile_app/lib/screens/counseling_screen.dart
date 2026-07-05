import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';
import '../widgets/common.dart';

class CounselingScreen extends StatefulWidget {
  const CounselingScreen({super.key});
  @override
  State<CounselingScreen> createState() => _CounselingScreenState();
}

class _CounselingScreenState extends State<CounselingScreen>
    with SingleTickerProviderStateMixin {
  late TabController _tabs;

  @override
  void initState() { super.initState(); _tabs = TabController(length:2, vsync:this); }
  @override
  void dispose() { _tabs.dispose(); super.dispose(); }

  @override
  Widget build(BuildContext context) => Scaffold(
    appBar: AppBar(
      title: const Text('مشاوره آنلاین'),
      bottom: TabBar(
        controller: _tabs,
        indicatorColor: AppColors.accent,
        labelColor: Colors.white,
        unselectedLabelColor: Colors.white60,
        tabs: const [Tab(text:'ارسال پیام'), Tab(text:'پیگیری')],
      ),
    ),
    body: TabBarView(controller:_tabs, children:[
      const _SendForm(),
      const _TrackForm(),
    ]),
  );
}

class _SendForm extends StatefulWidget {
  const _SendForm();
  @override
  State<_SendForm> createState() => _SendFormState();
}

class _SendFormState extends State<_SendForm> {
  final _form = GlobalKey<FormState>();
  final _name = TextEditingController();
  final _nid  = TextEditingController();
  final _mob  = TextEditingController();
  final _subj = TextEditingController();
  final _msg  = TextEditingController();
  String _type = 'student';
  String _via  = 'sms';
  bool _loading = false;

  @override
  void dispose() {
    for (var c in [_name,_nid,_mob,_subj,_msg]) c.dispose();
    super.dispose();
  }

  Future<void> _send() async {
    if (!_form.currentState!.validate()) return;
    setState(() => _loading = true);
    try {
      final res = await ApiService.submitCounseling({
        'sender_type':_type, 'full_name':_name.text.trim(),
        'national_id':_nid.text.trim(), 'mobile':_mob.text.trim(),
        'reply_via':_via, 'subject':_subj.text.trim(),
        'message':_msg.text.trim(), 'is_private':true,
      });
      if (!mounted) return;
      if (res['success']==true) {
        for (var c in [_name,_nid,_mob,_subj,_msg]) c.clear();
        ScaffoldMessenger.of(context).showSnackBar(const SnackBar(
          content:Text('پیام شما با موفقیت ارسال شد'),
          backgroundColor:Colors.green));
      } else {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          content:Text(res['message']??'خطا'), backgroundColor:Colors.red));
      }
    } catch(_) {
      if(mounted) ScaffoldMessenger.of(context).showSnackBar(const SnackBar(
        content:Text('خطا در اتصال به سرور'), backgroundColor:Colors.red));
    } finally {
      if (mounted) setState(() => _loading = false);
    }
  }

  @override
  Widget build(BuildContext context) => SingleChildScrollView(
    padding:const EdgeInsets.all(16),
    child:Form(key:_form, child:Column(children:[
      Container(padding:const EdgeInsets.all(12),
        decoration:BoxDecoration(color:AppColors.primary.withOpacity(0.07),
            borderRadius:BorderRadius.circular(10)),
        child:const Row(children:[
          Icon(Icons.lock_outline, size:16, color:AppColors.accent),
          SizedBox(width:8),
          Expanded(child:Text('این پیام فقط برای مدیر و مشاور هنرستان قابل مشاهده است.',
              style:TextStyle(fontSize:12))),
        ])),
      const SizedBox(height:16),

      DropdownButtonFormField<String>(value:_type,
        decoration:const InputDecoration(labelText:'ارسال از جانب'),
        onChanged:(v)=>setState(()=>_type=v!),
        items:const [
          DropdownMenuItem(value:'student',child:Text('دانش‌آموز')),
          DropdownMenuItem(value:'parent',child:Text('والدین')),
        ]),
      const SizedBox(height:12),
      TextFormField(controller:_name,
        decoration:const InputDecoration(labelText:'نام و نام خانوادگی *'),
        validator:(v)=>(v?.isEmpty??true)?'الزامی است':null),
      const SizedBox(height:12),
      TextFormField(controller:_nid, keyboardType:TextInputType.number,
        maxLength:10, textDirection:TextDirection.ltr,
        decoration:const InputDecoration(labelText:'کد ملی *', counterText:''),
        validator:(v)=>(v?.length!=10)?'۱۰ رقم':null),
      const SizedBox(height:12),
      TextFormField(controller:_mob, keyboardType:TextInputType.phone,
        textDirection:TextDirection.ltr,
        decoration:const InputDecoration(labelText:'موبایل *'),
        validator:(v)=>(v?.isEmpty??true)?'الزامی است':null),
      const SizedBox(height:12),
      TextFormField(controller:_subj,
        decoration:const InputDecoration(labelText:'موضوع *'),
        validator:(v)=>(v?.isEmpty??true)?'الزامی است':null),
      const SizedBox(height:12),
      TextFormField(controller:_msg, maxLines:4,
        decoration:const InputDecoration(labelText:'متن پیام *', alignLabelWithHint:true),
        validator:(v)=>((v?.length??0)<5)?'حداقل ۵ کاراکتر':null),
      const SizedBox(height:12),
      DropdownButtonFormField<String>(value:_via,
        decoration:const InputDecoration(labelText:'ارسال پاسخ از طریق'),
        onChanged:(v)=>setState(()=>_via=v!),
        items:const [
          DropdownMenuItem(value:'sms',child:Text('پیامک')),
          DropdownMenuItem(value:'email',child:Text('ایمیل')),
        ]),
      const SizedBox(height:20),
      PrimaryButton(label:'ارسال پیام', onPressed:_send, loading:_loading),
    ])),
  );
}

class _TrackForm extends StatefulWidget {
  const _TrackForm();
  @override
  State<_TrackForm> createState() => _TrackFormState();
}

class _TrackFormState extends State<_TrackForm> {
  final _nid = TextEditingController();
  final _mob = TextEditingController();
  List? _results;
  bool _loading = false;
  bool _searched = false;

  Future<void> _track() async {
    if (_nid.text.length!=10||_mob.text.isEmpty) return;
    setState(() { _loading=true; _searched=false; });
    try {
      final d = await ApiService.trackCounseling(_nid.text.trim(), _mob.text.trim());
      if (mounted) setState(() {
        _results = d['data'] as List?;
        _loading=false; _searched=true;
      });
    } catch(_) {
      if (mounted) setState(() => _loading=false);
    }
  }

  @override
  Widget build(BuildContext context) => SingleChildScrollView(
    padding:const EdgeInsets.all(16),
    child:Column(children:[
      TextFormField(controller:_nid, keyboardType:TextInputType.number,
        maxLength:10, textDirection:TextDirection.ltr,
        decoration:const InputDecoration(labelText:'کد ملی', counterText:'')),
      const SizedBox(height:12),
      TextFormField(controller:_mob, keyboardType:TextInputType.phone,
        textDirection:TextDirection.ltr,
        decoration:const InputDecoration(labelText:'شماره موبایل')),
      const SizedBox(height:16),
      PrimaryButton(label:'جست‌وجو', onPressed:_track, loading:_loading),
      const SizedBox(height:20),

      if (_searched && (_results==null||_results!.isEmpty))
        const EmptyState(icon:Icons.search_off, message:'پیامی با این مشخصات یافت نشد'),

      if (_results!=null && _results!.isNotEmpty)
        ..._results!.map((r) => Card(
          margin:const EdgeInsets.only(bottom:12),
          child:Padding(padding:const EdgeInsets.all(14), child:Column(
            crossAxisAlignment:CrossAxisAlignment.start, children:[
              Row(mainAxisAlignment:MainAxisAlignment.spaceBetween, children:[
                Expanded(child:Text(r['subject']??'',
                    style:const TextStyle(fontWeight:FontWeight.bold))),
                StatusBadge(
                  label: r['status']=='answered'?'پاسخ داده شده':'در انتظار',
                  color: r['status']=='answered'?Colors.green:Colors.orange,
                ),
              ]),
              if (r['status']=='answered') ...[
                const Divider(height:16),
                const Text('پاسخ:', style:TextStyle(fontWeight:FontWeight.w600,
                    color:Colors.green)),
                const SizedBox(height:4),
                Text(r['response_text']??'', style:const TextStyle(fontSize:13, height:1.7)),
              ],
            ])),
        )).toList(),
    ]),
  );
}
