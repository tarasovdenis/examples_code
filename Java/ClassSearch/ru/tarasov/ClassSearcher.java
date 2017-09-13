package ru.tarasov;

import java.io.File;
import java.util.Date;
import java.util.Random;

public class ClassSearcher {
	public static void main(String[] args) {
		
		String [] classNames = { "regidle.dll.mui", "regsvc.dll.mui", "regsvr32.exe.mui", "rekeywiz.exe.mui",
				"relog.exe.mui", "RelPost.exe.mui", "remotepg.dll.mui", "repair-bde.exe.mui", "replace.exe.mui",
				"reset.exe.mui", "RestartManager.mfl", "RestartManagerUninstall.mfl", "Ribbons.scr.mui",
				"RmClient.exe.mui", "Robocopy.exe.mui", "route.exe.mui", "RpcEpMap.dll.mui", "rpchttp.dll.mui",
				"RPCNDFP.dll.mui", "RpcNs4.dll.mui", "rpcnsh.dll.mui", "rpcping.exe.mui", "rpcrt4.dll.mui",
				"rrinstaller.exe.mui", "rshx32.dll.mui", "RSMGRSTR.dll.mui", "rsop.msc", "rstrtmgr.dll.mui",
				"rstrui.exe.mui", "rtffilt.dll.mui", "rtm.dll.mui", "runas.exe.mui", "rundll32.exe.mui",
				"RunLegacyCPLElevated.exe.mui", "runonce.exe.mui", "RW001Ext.dll.mui", "RW330Ext.dll.mui",
				"RW430Ext.dll.mui", "RW450Ext.dll.mui", "RWia001.dll.mui", "RWia330.dll.mui", "RWia430.dll.mui",
				"RWia450.dll.mui", "rwinsta.exe.mui", "SampleRes.dll.mui", "samsrv.dll.mui", "sberes.dll.mui",
				"sc.exe.mui", "scansetting.dll.mui", "SCardDlg.dll.mui", "SCardSvr.dll.mui", "scavengeui.dll.mui",
				"sccls.dll.mui", "scecli.dll.mui", "scesrv.dll.mui", "scext.dll.mui", "schedsvc.dll.mui",
				"schtasks.exe.mui", "scksp.dll.mui", "scripto.dll.mui", "scrnsave.scr.mui", "scrobj.dll.mui",
				"scrptadm.dll.mui", "scrrun.dll.mui", "sdautoplay.dll.mui", "sdbinst.exe.mui", "sdchange.exe.mui",
				"sdclt.exe.mui", "sdcpl.dll.mui", "sdengin2.dll.mui", "sdiageng.dll.mui", "sdiagnhost.exe.mui",
				"sdiagprv.dll.mui", "sdiagschd.dll.mui", "sdohlp.dll.mui", "sdrsvc.dll.mui", "sdshext.dll.mui",
				"searchfolder.dll.mui", "SearchIndexer.exe.mui", "secedit.exe.mui", "secinit.exe.mui",
				"seclogon.dll.mui", "secpol.msc", "sendmail.dll.mui", "sens.dll.mui", "SensorsCpl.dll.mui",
				"sensrsvc.dll.mui", "serialui.dll.mui", "services.exe.mui", "services.msc", "serwvdrv.dll.mui",
				"sessenv.dll.mui", "sethc.exe.mui", "setspn.exe.mui", "setupapi.dll.mui", "setupcl.exe.mui",
				"setupcln.dll.mui", "setupetw.dll.mui", "setupSNK.exe.mui", "setupugc.exe.mui", "setx.exe.mui",
				"sfc.exe.mui", "shadow.exe.mui", "sharemediacpl.dll.mui", "shdocvw.dll.mui", "shell32.dll.mui",
				"shimgvw.dll.mui", "shlwapi.dll.mui", "shrpubw.exe.mui", "shsvcs.dll.mui", "shutdown.exe.mui",
				"shwebsvc.dll.mui", "sigverif.exe.mui", "slc.dll.mui", "slcext.dll.mui", "slui.exe.mui",
				"SmartcardCredentialProvider.dll.mui", "SMBHelperClass.dll.mui", "smss.exe.mui", "sndvol.exe.mui",
				"sndvolsso.dll.mui", "SnippingTool.exe.mui", "snmptrap.exe.mui", "sntsearch.dll.mui",
				"SODPPLM2.DLL.mui", "softkbd.dll.mui", "sort.exe.mui", "SoundRecorder.exe.mui", "spcmsg.dll.mui",
				"sperror.dll.mui", "spoolsv.exe.mui", "spp.dll.mui", "sppc.dll.mui", "sppcc.dll.mui", "sppcext.dll.mui",
				"sppcomapi.dll.mui", "sppcommdlg.dll.mui", "sppnp.dll.mui", "sppsvc.exe.mui", "sppuinotify.dll.mui",
				"spwizres.dll.mui", "spwizui.dll.mui", "sqlsrv32.rll.mui", "srchadmin.dll.mui", "srcore.dll.mui",
				"SrpUxNativeSnapIn.dll.mui", "srrstr.dll.mui", "srvsvc.dll.mui", "sscore.dll.mui", "ssdpsrv.dll.mui",
				"ssText3d.scr.mui", "sstpsvc.dll.mui", "sti.dll.mui", "StikyNot.exe.mui", "sti_ci.dll.mui",
				"stobject.dll.mui", "StorageContextHandler.dll.mui", "Storprop.dll.mui", "subst.exe.mui", "sud.dll.mui",
				"svchost.exe.mui", "swprv.dll.mui", "sxproxy.dll.mui", "sxs.dll.mui", "sxstrace.exe.mui",
				"SyncCenter.dll.mui", "SyncInfrastructure.dll.mui", "syncreg.dll.mui", "syncui.dll.mui",
				"sysclass.dll.mui", "sysdm.cpl.mui", "SysFxUI.dll.mui", "syskey.exe.mui", "sysmain.dll.mui",
				"sysmon.ocx.mui", "systemcpl.dll.mui", "systeminfo.exe.mui", "SystemPropertiesAdvanced.exe.mui",
				"SystemPropertiesComputerName.exe.mui", "SystemPropertiesDataExecutionPrevention.exe.mui",
				"SystemPropertiesHardware.exe.mui", "SystemPropertiesPerformance.exe.mui",
				"SystemPropertiesProtection.exe.mui", "SystemPropertiesRemote.exe.mui", "Tabbtn.dll.mui",
				"tabcal.exe.mui", "TabletPC.cpl.mui", "TabSvc.dll.mui", "takeown.exe.mui", "tapi3.dll.mui",
				"tapi32.dll.mui", "tapisrv.dll.mui", "tapiui.dll.mui", "taskbarcpl.dll.mui", "taskcomp.dll.mui",
				"TaskEng.exe.mui", "taskhost.exe.mui", "taskkill.exe.mui", "tasklist.exe.mui", "taskmgr.exe.mui",
				"taskschd.msc", "tbssvc.dll.mui", "tcmsetup.exe.mui", "tcpipcfg.dll.mui", "TCPMON.dll.mui",
				"TCPMonUI.dll.mui", "tdh.dll.mui", "telephon.cpl.mui", "termsrv.dll.mui", "themecpl.dll.mui",
				"themeservice.dll.mui", "themeui.dll.mui", "thumbcache.dll.mui", "timedate.cpl.mui", "timeout.exe.mui",
				"tpm.msc", "tpmcompc.dll.mui", "TpmInit.exe.mui", "tquery.dll.mui", "tracerpt.exe.mui",
				"tracert.exe.mui", "trkwks.dll.mui", "tscon.exe.mui", "tsdiscon.exe.mui", "tsgqec.dll.mui",
				"tskill.exe.mui", "tsmf.dll.mui", "TsUsbGDCoInstaller.dll.mui",
				"TsUsbRedirectionGroupPolicyExtension.dll.mui", "TSWorkspace.dll.mui", "twext.dll.mui",
				"typeperf.exe.mui", "tzres.dll.mui", "tzutil.exe.mui", "ubpm.dll.mui", "ucmhc.dll.mui", "uDWM.dll.mui",
				"ui0detect.exe.mui", "UIAutomationCore.dll.mui", "uicom.dll.mui", "UIHub.dll.mui", "UIRibbon.dll.mui",
				"ulib.dll.mui", "umpnpmgr.dll.mui", "umpo.dll.mui", "umrdp.dll.mui", "unimdm.tsp.mui",
				"unimdmat.dll.mui", "unlodctr.exe.mui", "unregmp2.exe.mui", "upnp.dll.mui", "upnphost.dll.mui",
				"urlmon.dll.mui", "usbceip.dll.mui", "usbmon.dll.mui", "usbperf.dll.mui", "usbui.dll.mui",
				"user32.dll.mui", "UserAccountControlSettings.dll.mui", "usercpl.dll.mui", "userenv.dll.mui",
				"userinit.exe.mui", "usk.rs.mui", "utildll.dll.mui", "Utilman.exe.mui", "uxtheme.dll.mui",
				"VAN.dll.mui", "Vault.dll.mui", "VaultCmd.exe.mui", "VaultCredProvider.dll.mui", "vaultsvc.dll.mui",
				"VaultSysUi.exe.mui", "vbscript.dll.mui", "vds.exe.mui", "vdsbas.dll.mui", "vdsdyn.dll.mui",
				"vdsutil.dll.mui", "verifier.exe.mui", "vfwwdm32.dll.mui", "vssadmin.exe.mui", "vsstrace.dll.mui",
				"VSSVC.exe.mui", "w32time.dll.mui", "w32tm.exe.mui", "WABSyncProvider.dll.mui", "waitfor.exe.mui",
				"wavemsp.dll.mui", "wbadmin.exe.mui", "wbengine.exe.mui", "wbiosrvc.dll.mui", "wcncsvc.dll.mui",
				"WcnNetsh.dll.mui", "wcnwiz.dll.mui", "WcsPlugInService.dll.mui", "wdc.dll.mui", "wdi.dll.mui",
				"wdmaud.drv.mui", "WEB.rs.mui", "webcheck.dll.mui", "webclnt.dll.mui", "webio.dll.mui",
				"webservices.dll.mui", "wecsvc.dll.mui", "wecutil.exe.mui", "wer.dll.mui", "werconcpl.dll.mui",
				"wercplsupport.dll.mui", "WerFault.exe.mui", "WerFaultSecure.exe.mui", "wersvc.dll.mui",
				"werui.dll.mui", "wevtapi.dll.mui", "wevtsvc.dll.mui", "wextract.exe.mui", "WF.msc", "WfHC.dll.mui",
				"WFSR.dll.mui", "whealogr.dll.mui", "where.exe.mui", "whhelper.dll.mui", "whoami.exe.mui",
				"wiaacmgr.exe.mui", "wiaaut.dll.mui", "wiadefui.dll.mui", "wiadss.dll.mui", "wiafbdrv.dll.mui",
				"wiascanprofiles.dll.mui", "wiaservc.dll.mui", "wiashext.dll.mui", "wimgapi.dll.mui", "win32k.sys.mui",
				"win32spl.dll.mui", "winbio.dll.mui", "wincredprovider.dll.mui", "windowsanytimeupgradeResults.exe.mui",
				"winethc.dll.mui", "winhttp.dll.mui", "wininet.dll.mui", "wininit.exe.mui", "winload.exe.mui",
				"winlogon.exe.mui", "winmm.dll.mui", "winresume.exe.mui", "Winrs.exe.mui", "WinSAT.exe.mui",
				"WinSATAPI.dll.mui", "WinSCard.dll.mui", "winsockhc.dll.mui", "winspool.drv.mui", "winsrv.dll.mui",
				"WinSync.rll.mui", "WinSyncMetastore.rll.mui", "WinSyncProviders.rll.mui", "winver.exe.mui",
				"wisptis.exe.mui", "wksprt.exe.mui", "wkssvc.dll.mui", "wlanapi.dll.mui", "wlancfg.dll.mui",
				"WLanConn.dll.mui", "wlandlg.dll.mui", "wlanext.exe.mui", "wlangpui.dll.mui", "WLanHC.dll.mui",
				"wlanmm.dll.mui", "wlanpref.dll.mui", "wlansvc.dll.mui", "wlanui.dll.mui", "wlanutil.dll.mui",
				"wldap32.dll.mui", "wlgpclnt.dll.mui", "wmerror.dll.mui", "WmiMgmt.msc", "wmiprop.dll.mui",
				"wmpdui.dll.mui", "WMPhoto.dll.mui", "wmploc.DLL.mui", "wmpshell.dll.mui", "Wpc.dll.mui",
				"wpcao.dll.mui", "wpccpl.dll.mui", "wpcmig.dll.mui", "wpcsvc.dll.mui", "wpcumi.dll.mui",
				"WpdBusEnum.dll.mui", "wpdshext.dll.mui", "WPDShextAutoplay.exe.mui", "wpdwcn.dll.mui",
				"wpd_ci.dll.mui", "wpnpinst.exe.mui", "ws2_32.dll.mui", "wscript.exe.mui", "wscsvc.dll.mui",
				"wscui.cpl.mui", "wsdapi.dll.mui", "WSDMon.dll.mui", "WSDScDrv.dll.mui", "wsecedit.dll.mui",
				"wsepno.dll.mui", "wshelper.dll.mui", "wshext.dll.mui", "wship6.dll.mui", "wshom.ocx.mui",
				"wshqos.dll.mui", "wshrm.dll.mui", "wshtcpip.dll.mui", "WsmRes.dll.mui", "WsmSvc.dll.mui",
				"wsock32.dll.mui", "wsqmcons.exe.mui", "wuapi.dll.mui", "wuaueng.dll.mui", "wucltux.dll.mui",
				"WUDFHost.exe.mui", "wudfplatform.dll.mui", "wudfsvc.dll.mui", "wusa.exe.mui", "wvc.dll.mui",
				"wwanadvui.dll.mui", "wwancfg.dll.mui", "wwanconn.dll.mui", "WWanHC.dll.mui", "WWanMM.dll.mui",
				"Wwanpref.dll.mui", "wwansvc.dll.mui", "wzcdlg.dll.mui", "XInput9_1_0.dll.mui", "xlog.exe.mui",
				"xmlfilter.dll.mui", "xpsfilt.dll.mui", "xpsrchvw.exe.mui", "xrWCbgnd.dll.mui", "xrWCtmg2.dll.mui",
				"xrWPcoin.dll.mui", "xrWPcpl.dll.mui", "xrWPcpst.dll.mui", "xrWPusd.dll.mui", "xwizard.exe.mui",
				"xwizards.dll.mui", "xwtpdui.dll.mui", "xwtpw32.dll.mui", "zipfldr.dll.mui", "runas.exe",
				"rundll32.exe", "RunLegacyCPLElevated.exe", "runonce.exe", "rwinsta.exe", "samcli.dll", "samlib.dll",
				"SampleRes.dll", "samsrv.dll", "sas.dll", "sbe.dll", "sbeio.dll", "sberes.dll", "sbunattend.exe",
				"sc.exe", "scansetting.dll", "SCardDlg.dll", "SCardSvr.dll", "ScavengeSpace.xml", "scavengeui.dll",
				"sccls.dll", "scecli.dll", "scesrv.dll", "scext.dll", "schannel.dll", "schedcli.dll", "schedsvc.dll",
				"schtasks.exe", "scksp.dll", "scripto.dll", "scrnsave.scr", "scrobj.dll", "scrptadm.dll", "scrrun.dll",
				"sdautoplay.dll", "sdbinst.exe", "sdchange.exe", "sdclt.exe", "sdcpl.dll", "sdengin2.dll"};
		
		
		/*BinaryTree bt = new BinaryTree();
		long [] l = new long[classNames.length];
		for(int i = 0; i < classNames.length; i++){
			l[i] = (long)i;
			bt.insert(classNames[i], l[i]);
		}
		bt.search("re");*/
		
		long [] l = new long[classNames.length];
		Searcher s = new Searcher();
		s.refresh(classNames, l);
		long start = System.nanoTime();
		String [] result = s.guess("s");
		long finish = System.nanoTime();
		for(String r : result){
			System.out.println(r);
		}
		System.out.println("\n" + (finish - start));
	}
}
