<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TerminalRepository")
 */
class Terminal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $input;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $lines;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phpsessid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $directory;

    public function __construct(){
        $this->directory='~';
        $this->setLines(
            array(
                "██╗--------██╗███████╗██╗----------██╗------------██████╗--██████╗--███╗------███╗███████╗",
                "██║--------██║██╔════╝██║----------██║----------██╔════╝██╔═══██╗████╗--████║██╔════╝",
                "██║--█╗--██║█████╗----██║----------██║----------██║----------██║------██║██╔████╔██║█████╗",
                "██║███╗██║██╔══╝----██║----------██║----------██║----------██║------██║██║╚██╔╝██║██╔══╝",
                "╚███╔███╔╝███████╗███████╗███████╗╚██████╗╚██████╔╝██║--╚═╝--██║███████╗",
                "--╚══╝╚══╝--╚══════╝╚══════╝╚══════╝--╚═════╝--╚═════╝--╚═╝----------╚═╝╚══════╝",
                " ",
                "Hi, I am a backend developer, I like dark interfaces, and so is my website...",
                " ",
            )
        );
        $this->setInput("help");
        $this->resolveInput();
        $this->addLine("diego@gamma ~ $ ./about_me");
    }

    public function getId()
    {
        return $this->id;
    }

    public function getInput(): ?string
    {
        return $this->input;
    }

    public function setInput(?string $input): self
    {
        $this->input = $input;

        return $this;
    }

    public function getLines(): ?array
    {
        return $this->lines;
    }

    public function setLines(?array $lines): self
    {
        $this->lines = $lines;

        return $this;
    }

    public function getPhpsessid()
    {
        return $this->phpsessid;
    }

    public function setPhpsessid($phpsessid): self
    {
        $this->phpsessid = $phpsessid;

        return $this;
    }

    public function addLine($input): self
    {
        array_push($this->lines,$input);

        $this->removeLine(0);

        return $this;
    }

    public function removeLine(int $numberOfLines): self
    {
        if ($numberOfLines==0)
        {
            $numberOfLines=count($this->getLines())-21;
        }


        if ($numberOfLines>0 && count($this->getLines())>=$numberOfLines)
        {
            for (; $numberOfLines>0 ; $numberOfLines--)
            {
                array_shift($this->lines); //deletes the oldest line (pop front)
            }
        }


        return $this;
    }

    public function resolveInput()
    {
        //adds the line of the command input to the terminal lines
        $this->addLine('diego@gamma '.$this->directory.' $ '.$this->getInput());
        //interprets the command
        $route=$this->resolveCommand();
        $this->setInput('');
        return $route;
    }

    private function resolveCommand()
    {
        $terminalName="wt";
        $regexCd = "/^cd[\ ]{1}.*/";
        $regexCdHome = "/^cd$/";
        $regexLs = "/^ls$/";
        $regexHelp = "/^help$/";
        $regexClear = "/^clear$/";
        $regexReset = "/^reset$/";
        $regexPointSlash = "/^./";

        if (preg_match($regexLs, $this->getInput())) {
            if ($this->directory=='~'){
                $this->addLine(".");
                $this->addLine("..");
                $this->addLine("resume");
                $this->addLine("about_me");
                $this->addLine("contact_me");
                $this->addLine("projects");
                $this->addLine("github");
                $this->addLine("linkeding");
                return null;
            }
            return null;
        }

        if (preg_match($regexCd, $this->getInput())) {//cd is not a directory
            if ($this->input=='cd resume'   || $this->input=='cd about_me' || $this->input=='cd contact_me'
            ||  $this->input=='cd projects' || $this->input=='cd github'   || $this->input=='cd linkeding')
            {
                $this->addLine("cd: not a directory: ".substr($this->getInput(),2));
                $this->addLine($terminalName.": exit 1");
                return null;
            }

            if ($this->getInput()=='cd ..' && $this->directory=='~'){//access denied
                $this->addLine("cd: permission denied: ".substr($this->getInput(),2));
                $this->addLine($terminalName.": exit 1");
                return null;
            }

            //the file does not exist
            $this->addLine("cd: no such file or directory: ".substr($this->getInput(),2));
            $this->addLine($terminalName.": exit 1");
            return null;
        }

        if (preg_match($regexCdHome, $this->getInput())) {
            $this->directory='~';
            return null;
        }

        if (preg_match($regexHelp, $this->getInput())) {
            $this->addLine('This is a UNIX like terminal');
            $this->addLine("use the command 'ls' to list all files");
            $this->addLine("you can use './<filename>' to go to a certain page");
            $this->addLine("and 'cd <directory>' to change to another folder");
            return null;
        }

        if (preg_match($regexClear, $this->getInput())) {
            $this->clearTerminal();
            return null;
        }

        if (preg_match($regexReset, $this->getInput())) {
            $this->resetTerminal();
            return null;
        }

        if (preg_match($regexPointSlash, $this->getInput())) {
            switch ($this->getInput()){
                case "./resume":
                    return "/resume";

                case "./about_me":
                    return "/about_me";

                case "./contact_me":
                    return "/contact_me";

                case "./projects":
                    return "/projects";

                case "./github":
                    return "github";

                case "./linkeding":
                    return "linkeding";

                default:
                    $this->addLine("error 500, please contact the webmaster at www.github.com/riera90/my-website and open an issue, thanks.");
                    return null;
            }
        }

        $this->addLine($terminalName.": command not found: " . $this->getInput());
        $this->addLine($terminalName.": exit 127.");
    }

    public function clearTerminal()
    {
        $this->setLines(
            array(
                "██╗--------██╗███████╗██╗----------██╗------------██████╗--██████╗--███╗------███╗███████╗",
                "██║--------██║██╔════╝██║----------██║----------██╔════╝██╔═══██╗████╗--████║██╔════╝",
                "██║--█╗--██║█████╗----██║----------██║----------██║----------██║------██║██╔████╔██║█████╗",
                "██║███╗██║██╔══╝----██║----------██║----------██║----------██║------██║██║╚██╔╝██║██╔══╝",
                "╚███╔███╔╝███████╗███████╗███████╗╚██████╗╚██████╔╝██║--╚═╝--██║███████╗",
                "--╚══╝╚══╝--╚══════╝╚══════╝╚══════╝--╚═════╝--╚═════╝--╚═╝----------╚═╝╚══════╝",
                " ",
                "Hi, I am a backend developer, I like dark interfaces, and so is my website...",
                " ",
            )
        );
    }

    public function resetTerminal()
    {
        $this->directory='~';
        $this->setLines(
            array(
                "██╗--------██╗███████╗██╗----------██╗------------██████╗--██████╗--███╗------███╗███████╗",
                "██║--------██║██╔════╝██║----------██║----------██╔════╝██╔═══██╗████╗--████║██╔════╝",
                "██║--█╗--██║█████╗----██║----------██║----------██║----------██║------██║██╔████╔██║█████╗",
                "██║███╗██║██╔══╝----██║----------██║----------██║----------██║------██║██║╚██╔╝██║██╔══╝",
                "╚███╔███╔╝███████╗███████╗███████╗╚██████╗╚██████╔╝██║--╚═╝--██║███████╗",
                "--╚══╝╚══╝--╚══════╝╚══════╝╚══════╝--╚═════╝--╚═════╝--╚═╝----------╚═╝╚══════╝",
                " ",
                "Hi, I am a backend developer, I like dark interfaces, and so is my website...",
                " ",
            )
        );
        $this->setInput("help");
        $this->resolveInput();
        $this->addLine("diego@gamma ~ $ ./about_me");
    }


}
