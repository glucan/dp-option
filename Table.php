<?php
require_once 'Manager.php';
require_once 'Escape.php';


class Table {
    protected $level;
    function __construct($level) {
        $this->level = sprintf('%.1f', $level);
    }

    public function printTable() {
        $songNum = $easyNum = $hardNum = 0;
echo <<< END
        <h2>{$this->level}</h2>
        <table class="table table-bordered" style="table-layout: fixed">
            <thead>
                <tr>
                    <th class="col-xs-7">TITLE</th>
                    <th class="col-xs-1">VERSION</th>
                    <th class="col-xs-2">CLEAR</th>
                    <th class="col-xs-2">OP</th>
                </tr>
            </thead>

END;
        try {
            $db = connect();
            //プリペアドステートメントを生成
            $stt = $db->prepare("SELECT so.id, so.title, so.version, c.status,
                                st.left_op, st.right_op, st.flip, st.clear
                                FROM songs so, status st, clear c
                                WHERE so.level = $this->level
                                AND so.id = st.songid
                                AND st.clear = c.id");
            //プリペアドステートメントを実行
            $stt->execute();
            //結果セットからレコードのデータをフェッチする
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                $songNum++;
                if ($row['clear'] == 3) {
                    $easyNum++;
                }
                if ($row['clear'] == 5) {
                    $hardNum++;
                }
                switch ($row['clear']) {
                    case '1':
                        $lampName = "FAILED";
                        break;
                    case '2':
                        $lampName = "ASSIST";
                        break;
                    case '3':
                        $lampName = "EASY";
                        break;
                    case '4':
                        $lampName = "CLEAR";
                        break;
                    case '5':
                        $lampName = "HARD";
                        break;
                    case '6':
                        $lampName = "EXH";
                        break;
                    case '7':
                        $lampName = "FC";
                        break;

                    default:
                        $lampName = "NOPLAY";
                        break;
                }
echo <<< END
            <tbody>
                <tr class="{$lampName}" data-toggle="modal" data-target="#{$row['id']}">
                    <td>{$row['title']}</td>
                    <td>{$row['version']}</td>
                    <td>{$row['status']}</td>
                    <td>
END;
                if ($row['flip'] == 1) {
                        echo "FLIP";
                }
                switch ($row['left_op']) {
                    case 1:
                        echo "左乱";
                        break;

                    case 2:
                        echo "左R乱";
                        break;

                    case 3:
                        echo "左S乱";
                        break;

                    case 4:
                        echo "左鏡";
                        break;
                }
                switch ($row['right_op']) {
                    case 1:
                        echo "右乱";
                        break;

                    case 2:
                        echo "右R乱";
                        break;

                    case 3:
                        echo "右S乱";
                        break;

                    case 4:
                        echo "右鏡";
                        break;
                }
echo <<< END
                    </td>
                </tr>
            </tbody>

END;
            }
            $db = null;
        } catch(PDOException $e) {
            die("エラーが発生しました。:{$e->getMessage()}");
        }
echo <<< END
        </table>
        <p>{$songNum}songs EASY:{$easyNum} HARD:{$hardNum}</p>
END;
    }

    public function printModal() {
        try {
            $db = connect();
            //プリペアドステートメントを生成
            $stt = $db->prepare("SELECT so.id, so.title, so.version, c.status,
                                st.left_op, st.right_op, st.flip, st.clear
                                FROM songs so, status st, clear c
                                WHERE so.level = $this->level
                                AND so.id = st.songid
                                AND st.clear = c.id");
            //プリペアドステートメントを実行
            $stt->execute();
            //結果セットからレコードのデータをフェッチする
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
echo <<< END
        <div class="modal fade" id="{$row['id']}" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title" id="exampleModal3Label">{$row['title']}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="Register.php" method="post" accept-charset="utf-8">
                  <div class="modal-body">
                    <h5>CLEAR LAMP</h5>
                    <p>
                        <select name="clear">
                            <option value="7"
END;
                if ($row['clear'] == 7) {echo " selected";}
                echo ">FC</option>\n                            <option value=\"6\"";
                if ($row['clear'] == 6) {echo " selected";}
                echo ">EXH</option>\n                            <option value=\"5\"";
                if ($row['clear'] == 5) {echo " selected";}
                echo ">H</option>\n                            <option value=\"4\"";
                if ($row['clear'] == 4) {echo " selected";}
                echo ">C</option>\n                            <option value=\"3\"";
                if ($row['clear'] == 3) {echo " selected";}
                echo ">E</option>\n                            <option value=\"2\"";
                if ($row['clear'] == 2) {echo " selected";}
                echo ">A</option>\n                            <option value=\"1\"";
                if ($row['clear'] == 1) {echo " selected";}
                echo ">F</option>\n                            <option value=\"0\"";
                if ($row['clear'] == 0) {echo " selected";}
                echo ">NP</option>\n";
echo <<< END
                        </select>
                    </p>
                    <h5>OPTION</h5>
                    <p>
                        FLIP:<select name="flip">
                            <option value="0">OFF</option>
                            <option value="1"
END;
                if ($row['flip'] == 1) {echo " selected";}
echo <<< END
                            >ON</option>
                        </select>
                        LEFT:<select name="left">
                            <option value="0">OFF</option>
                            <option value="1"
END;
                if ($row['left_op'] == 1) {echo " selected";}
                echo ">RANDOM</option>\n                            <option value=\"2\"";
                if ($row['left_op'] == 2) {echo " selected";}
                echo ">R-RAN</option>\n                            <option value=\"3\"";
                if ($row['left_op'] == 3) {echo " selected";}
                echo ">S-RAN</option>\n                            <option value=\"4\"";
                if ($row['left_op'] == 4) {echo " selected";}
                echo ">MIRROR</option>\n";
echo <<< END
                        </select>
                        RIGHT:<select name="right">
                            <option value="0">OFF</option>
                            <option value="1"
END;
                if ($row['right_op'] == 1) {echo " selected";}
                echo ">RANDOM</option>\n                            <option value=\"2\"";
                if ($row['right_op'] == 2) {echo " selected";}
                echo ">R-RAN</option>\n                            <option value=\"3\"";
                if ($row['right_op'] == 3) {echo " selected";}
                echo ">S-RAN</option>\n                            <option value=\"4\"";
                if ($row['right_op'] == 4) {echo " selected";}
                echo ">MIRROR</option>\n";
echo <<< END
                        </select>
                    </p>
                    <input type="hidden" name="id" value="{$row['id']}">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Save changes">
              </div>
                </form>
            </div>
          </div>
        </div>

END;
            }
            $db = null;
        } catch(PDOException $e) {
            die("エラーが発生しました。:{$e->getMessage()}");
        }

    }

}
