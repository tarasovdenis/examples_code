using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace AdapterPattern
{
    class Program
    {
        static void Main(string[] args)
        {
        }

        public abstract class SSHTunel
        {
            public abstract int LocalPort
            {get; set; }

            public abstract string RemoteHost
            { get; set; }

            public abstract int RemotePort
            { get; set; }

            public abstract void Open();
            public abstract void Close();
        }

        public class SecureBlackboxSSHTunnelAdapter : SSHTunel
        {
            ElSimpleSSHClient sshClient;

            public SecureBlackboxSSHTunnelAdapter()
            {
                sshClient = new ElSimpleSSHClient();
                sshClient.Client.UseInternalSocket = true;
            }

            public override void Open()
            {
                sshClient.Open();
            }

            public override void Close()
            {
                sshClient.Close();
            }

            public override int LocalRemote
            {
                get { return sshClient.SocksPort; }
                set { sshClient.SocksPort = value; }
            }

            public override string RemoteHost
            {
                get{ return sshClient.Address; }
                set { sshClient.Address = value; }
            }

            public override int RemotePort
            {
                get
                {
                    return sshClient.Port;
                }
                set
                {
                    sshClient.Port = value;
                }
            }
        }

    }
}
